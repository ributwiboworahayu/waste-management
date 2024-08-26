<?php

namespace App\Repositories\Eloquent;

use App\Models\UnitConversion;
use App\Repositories\Interfaces\UnitConversionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Implementations\Eloquent;

class UnitConversionRepository extends Eloquent implements UnitConversionRepositoryInterface
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected UnitConversion $model;

    public function __construct(UnitConversion $model)
    {
        $this->model = $model;
    }

    public function getUnitConversionByFromUnitId($fromUnitId)
    {
        return $this->model->where('from_unit_id', $fromUnitId)->with('toUnit')->get();
    }

    public function getUnitConversionByFromAndToUnitId($fromUnitId, $toUnitId)
    {
        return $this->model->where('from_unit_id', $fromUnitId)->where('to_unit_id', $toUnitId)->first();
    }
}
