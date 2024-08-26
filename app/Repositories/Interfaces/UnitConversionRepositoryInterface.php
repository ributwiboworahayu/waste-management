<?php

namespace App\Repositories\Interfaces;

use LaravelEasyRepository\Repository;

interface UnitConversionRepositoryInterface extends Repository
{

    public function getUnitConversionByFromUnitId($fromUnitId);

    public function getUnitConversionByFromAndToUnitId($fromUnitId, $toUnitId);
}
