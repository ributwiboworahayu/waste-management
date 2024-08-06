<?php

namespace App\Repositories\Eloquent;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use App\Models\Waste;

class WasteRepository extends Eloquent implements WasteRepositoryInterface{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Waste $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
