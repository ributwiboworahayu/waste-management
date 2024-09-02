<?php

namespace App\Services;

use App\Models\ListWaste;
use App\Repositories\Interfaces\DatatablesRepositoryInterface;
use App\Repositories\Interfaces\ListWasteRepositoryInterface;
use App\Repositories\Interfaces\UnitConversionRepositoryInterface;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use App\Repositories\Interfaces\WasteTransactionDetailRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;

class WasteService extends Service
{

    /**
     * don't change $this→mainInterface variable name
     * because used in extent service class
     */
    protected WasteRepositoryInterface $mainInterface;
    protected UnitRepositoryInterface $unitRepositoryInterface;
    protected ListWasteRepositoryInterface $liquidRepositoryInterface;
    protected UnitConversionRepositoryInterface $unitConversionRepositoryInterface;
    protected WasteTransactionDetailRepositoryInterface $wasteTransactionDetailRepositoryInterface;
    protected DatatablesRepositoryInterface $datatablesRepository;

    public function __construct(
        WasteRepositoryInterface                  $mainInterface,
        UnitRepositoryInterface                   $unitRepositoryInterface,
        ListWasteRepositoryInterface              $liquidRepositoryInterface,
        UnitConversionRepositoryInterface         $unitConversionRepositoryInterface,
        WasteTransactionDetailRepositoryInterface $wasteTransactionDetailRepositoryInterface,
        DatatablesRepositoryInterface             $datatablesRepository
    )
    {
        $this->mainInterface = $mainInterface;
        $this->unitRepositoryInterface = $unitRepositoryInterface;
        $this->liquidRepositoryInterface = $liquidRepositoryInterface;
        $this->unitConversionRepositoryInterface = $unitConversionRepositoryInterface;
        $this->wasteTransactionDetailRepositoryInterface = $wasteTransactionDetailRepositoryInterface;
        $this->datatablesRepository = $datatablesRepository;
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

    public function getLiquids($waste): ?Collection
    {
        $isB3 = $waste === 'b3';
        return $this->liquidRepositoryInterface->listWaste($isB3);
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
        $liquidWaste = $this->liquidRepositoryInterface->find($payload['list_waste_id']);
        if (!$liquidWaste) return ['error' => true, 'message' => 'Liquid waste not found'];

        $conversionValue = null;
        // check unit if same with liquid waste unit
        if ($payload['unit_id'] != $liquidWaste->unit_id) {
            $unitConversions = $this->unitConversionRepositoryInterface->getUnitConversionByFromAndToUnitId($payload['unit_id'], $liquidWaste->unit_id);
            if (!$unitConversions) return ['error' => true, 'message' => 'Unit conversion not found'];

            $conversionValue = self::convertValue($payload['quantity'], $unitConversions);
        }

        // check liquid waste quantity if enough
        if ($payload['type'] == 'out' && $liquidWaste->quantity < ($conversionValue ?? $payload['quantity'])) {
            return ['error' => true, 'message' => 'Stok cairan tidak mencukupi'];
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

            $imageName = $this->generateName($payload['shipper_name'], $payload['input_by']);
            $storeImage = $this->storeImage($payload['photo'], $imageName, 'photo');
            if ($storeImage['error']) return ['error' => true, 'message' => $storeImage['message']];

            $storeDocument = $this->storeImage($payload['document'], $imageName, 'document');
            if ($storeDocument['error']) return ['error' => true, 'message' => $storeDocument['message']];

            $payload['photoPath'] = $storeImage['data'];
            $payload['documentPath'] = $storeDocument['data'];
            $detailPayload = [
                'unit_id' => $payload['unit_id'],
                'unit_conversion_id' => $unitConversions->id ?? null,
                'list_waste_id' => $payload['list_waste_id'],
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

    public function getUnitByLiquid(ListWaste $liquidWaste): array
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
            'quantity' => $liquidWaste->quantity,
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

    /**
     * @param $id
     * @return array
     */
    public function show($id): array
    {
        $waste = $this->mainInterface->show($id);
        if (!$waste) return ['error' => true, 'message' => 'Data not found'];
        return ['error' => true, 'data' => $waste];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function datatables(Request $request): array
    {
        $datatables = $this->mainInterface->datatableQuery($request);
        $query = $datatables['query'];
        $columns = $datatables['columns'];
        $actionRoutes = [
            'detail' => 'waste.show',
            // 'edit' => 'waste.edit'
        ];

        $res = $this->datatablesRepository->applyDatatables(
            'id',
            $request,
            $query,
            $columns,
            $actionRoutes
        );

        // parse approved date to human-readable e.g.: 28 Agustus 2024 indonesia
        $res['data'] = $res['data']->map(function ($item) {
            $item->approved_date = Carbon::parse($item->approved_date)->translatedFormat('d F Y');
            return $item;
        });

        return $res;
    }

    private function storeImage($image, $fileName, $folder): array
    {
        if (!$image) return ['error' => true, 'message' => 'Image not found'];

        $imagePath = $image->storeAs('public/' . $folder, $fileName . '.' . $image->extension());
        if (!$imagePath) return ['error' => true, 'message' => 'Failed to store image'];

        // remove the public from a path
        $imagePath = str_replace('public/', '', $imagePath);
        return ['error' => false, 'data' => $imagePath];
    }

    private function generateName($shipperName, $inputBy): string
    {
        // make shipper name is a lower case and replace space with underscore
        $shipperName = str_replace(' ', '_', strtolower($shipperName));
        // make input by is lower case and replace space with underscore
        $inputBy = str_replace(' ', '_', strtolower($inputBy));

        return $inputBy . '-' . $shipperName . '-' . Carbon::now()->format('YmdHis');
    }
}
