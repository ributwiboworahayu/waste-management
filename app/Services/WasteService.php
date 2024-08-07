<?php

namespace App\Services;

use App\Repositories\Interfaces\UnitRepositoryInterface;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use LaravelEasyRepository\Service;

class WasteService extends Service
{

    /**
     * don't change $this->mainInterface variable name
     * because used in extends service class
     */
    protected WasteRepositoryInterface $mainInterface;
    protected UnitRepositoryInterface $unitRepositoryInterface;

    public function __construct(
        WasteRepositoryInterface $mainInterface,
        UnitRepositoryInterface  $unitRepositoryInterface
    )
    {
        $this->mainInterface = $mainInterface;
        $this->unitRepositoryInterface = $unitRepositoryInterface;
    }

    public function getUnits(): ?Collection
    {
        return $this->unitRepositoryInterface->all();
    }
}
