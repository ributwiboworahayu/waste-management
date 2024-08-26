<?php

namespace App\Repositories\Eloquent;

use App\Models\Waste;
use App\Models\WasteTransaction;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Implementations\Eloquent;

class WasteRepository extends Eloquent implements WasteRepositoryInterface
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected WasteTransaction $model;

    public function __construct(WasteTransaction $model)
    {
        $this->model = $model;
    }

    public function getLastCode()
    {
        return $this->model->latest()->first() ?? 'WST0000';
    }
}
