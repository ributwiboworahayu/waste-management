<?php

namespace App\Services;

use App\Models\LiquidWaste;
use App\Repositories\Interfaces\LiquidRepositoryInterface;
use App\Repositories\Interfaces\UnitConversionRepositoryInterface;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use Illuminate\Support\Collection;
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

    public function __construct(
        WasteRepositoryInterface          $mainInterface,
        UnitRepositoryInterface           $unitRepositoryInterface,
        LiquidRepositoryInterface         $liquidRepositoryInterface,
        UnitConversionRepositoryInterface $unitConversionRepositoryInterface
    )
    {
        $this->mainInterface = $mainInterface;
        $this->unitRepositoryInterface = $unitRepositoryInterface;
        $this->liquidRepositoryInterface = $liquidRepositoryInterface;
        $this->unitConversionRepositoryInterface = $unitConversionRepositoryInterface;
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
}
