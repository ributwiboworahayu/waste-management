<?php

namespace App\Services;

use App\Models\LiquidWaste;
use App\Repositories\Interfaces\LiquidRepositoryInterface;
use App\Repositories\Interfaces\UnitConversionRepositoryInterface;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use App\Repositories\Interfaces\WasteTransactionDetailRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;

class WasteService extends Service
{

    /**
     * don't change $this->mainInterface variable name
     * because used in extends service class
     */
    protected WasteRepositoryInterface $mainInterface;
    protected UnitRepositoryInterface $unitRepositoryInterface;
    protected LiquidRepositoryInterface $liquidRepositoryInterface;
    protected UnitConversionRepositoryInterface $unitConversionRepositoryInterface;
    protected WasteTransactionDetailRepositoryInterface $wasteTransactionDetailRepositoryInterface;

    public function __construct(
        WasteRepositoryInterface                  $mainInterface,
        UnitRepositoryInterface                   $unitRepositoryInterface,
        LiquidRepositoryInterface                 $liquidRepositoryInterface,
        UnitConversionRepositoryInterface         $unitConversionRepositoryInterface,
        WasteTransactionDetailRepositoryInterface $wasteTransactionDetailRepositoryInterface
    )
    {
        $this->mainInterface = $mainInterface;
        $this->unitRepositoryInterface = $unitRepositoryInterface;
        $this->liquidRepositoryInterface = $liquidRepositoryInterface;
        $this->unitConversionRepositoryInterface = $unitConversionRepositoryInterface;
        $this->wasteTransactionDetailRepositoryInterface = $wasteTransactionDetailRepositoryInterface;
    }

    public function getUnits(): ?Collection
    {
        return $this->unitRepositoryInterface->all()->map(function ($unit) {
            return [
                'id' => $unit->id,
                'text' => $unit->name,
                'symbol' => $unit->symbol,
            ];
        });
    }

    public function getLiquids(): ?Collection
    {
        return $this->liquidRepositoryInterface->all()->map(function ($liquid) {
            return [
                'id' => $liquid->id,
                'text' => $liquid->name,
                'unit' => $liquid->unit->name,
                'unit_id' => $liquid->unit->id,
            ];
        });
    }

    public function generateCode(): string
    {
        $lastCode = $this->mainInterface->getLastCode();
        $lastNumber = (int)substr($lastCode, -4);
        $newNumber = $lastNumber + 1;
        return 'WST' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function store($payload): array
    {
        $liquidWaste = $this->liquidRepositoryInterface->find($payload['liquid_waste_id']);
        if (!$liquidWaste) return ['error' => true, 'message' => 'Liquid waste not found'];

        $conversionValue = null;
        // check unit if same with liquid waste unit
        if ($payload['unit_id'] != $liquidWaste->unit_id) {
            $unitConversions = $this->unitConversionRepositoryInterface->getUnitConversionByFromAndToUnitId($payload['unit_id'], $liquidWaste->unit_id);
            if (!$unitConversions) return ['error' => true, 'message' => 'Unit conversion not found'];

            $conversionValue = self::convertValue($payload['quantity'], $unitConversions);
        }

        DB::beginTransaction();
        try {
            if ($payload['type'] == 'in') {
                $addedStock = $conversionValue ?? $payload['quantity'];
                $liquidWaste->increment('quantity', $addedStock);
            } else {
                $deductedStock = $conversionValue ?? $payload['quantity'];
                $liquidWaste->decrement('quantity', $deductedStock);
            }

            $detailPayload = [
                'unit_conversion_id' => $unitConversions->id ?? null,
                'liquid_waste_id' => $payload['liquid_waste_id'],
                'quantity' => $payload['quantity'],
                'conversion_value' => $conversionValue ?? $payload['quantity'],
                'photo' => $payload['photoPath'] ?? 'sembarang.jpg',
                'document' => $payload['documentPath'] ?? 'sembarang.jpg',
                'shipper_name' => $payload['shipper_name'],
                'input_by' => $payload['input_by'],
                'input_at' => $payload['input_at'],
                'description' => $payload['description'],
            ];
            $wasteDetail = $this->wasteTransactionDetailRepositoryInterface->store($detailPayload);

            $wastePayload = [
                'code' => $this->generateCode(),
                'waste_transaction_detail_id' => $wasteDetail->id,
                'quantity' => $payload['quantity'],
                'type' => $payload['type'],
                'approved_by' => Auth::id(),
                'approved_at' => Carbon::now(),
                'status' => $payload['status'],
                'description' => $payload['description'],
            ];
            $this->mainInterface->store($wastePayload);

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            return ['error' => true, 'message' => 'DB Error: ' . $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => true, 'message' => 'Terjadi kesalahan' . $e->getMessage()];
        }

        return ['error' => false, 'message' => 'Data berhasil disimpan'];
    }

    public function getUnitByLiquid(LiquidWaste $liquidWaste): array
    {
        $unitId = $liquidWaste->unit_id;
        $unitConversions = $this->unitConversionRepositoryInterface->getUnitConversionByFromUnitId($unitId);

        if ($unitConversions->isEmpty()) return ['error' => true, 'message' => 'Unit conversion not found'];

        $convertedUnits = $unitConversions->map(fn($conversion) => [
            'id' => $conversion->toUnit->id,
            'text' => $conversion->toUnit->name,
            'symbol' => $conversion->toUnit->symbol,
        ]);

        $defaultUnit = $this->unitRepositoryInterface->find($unitId);
        $convertedUnits->prepend([
            'id' => $defaultUnit->id,
            'default' => true,
            'text' => $defaultUnit->name,
            'symbol' => $defaultUnit->symbol,
        ]);

        return ['error' => false, 'data' => $convertedUnits];
    }

    /**
     * @param $value
     * @param $unitConversion
     * @return float|int
     */
    private static function convertValue($value, $unitConversion)
    {
        $rate = $unitConversion->conversion_rate;
        $operator = $unitConversion->operator;

        switch ($operator) {
            case '*':
                return $value * $rate;
            case '/':
                return $value / $rate;
            case '+':
                return $value + $rate;
            case '-':
                return $value - $rate;
            default:
                return $value;
        }
    }
}
