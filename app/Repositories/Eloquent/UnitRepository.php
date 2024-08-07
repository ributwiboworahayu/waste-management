<?php

namespace App\Repositories\Eloquent;

use App\Models\Unit;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use LaravelEasyRepository\Implementations\Eloquent;

class UnitRepository extends Eloquent implements UnitRepositoryInterface
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Unit $model;

    public function __construct(Unit $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function datatableQuery(Request $request): array
    {
        $query = $this->model->select('id', 'name', 'symbol', 'description');
        $columns = [
            'units.name',
            'units.symbol',
            'units.description',
        ];

        return [
            'query' => $query,
            'columns' => $columns
        ];
    }
}
