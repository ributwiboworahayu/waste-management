<?php

namespace App\Repositories\Eloquent;

use App\Models\Liquid;
use App\Models\LiquidWaste;
use App\Repositories\Interfaces\LiquidRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use LaravelEasyRepository\Implementations\Eloquent;

class LiquidRepository extends Eloquent implements LiquidRepositoryInterface
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected LiquidWaste $model;

    public function __construct(LiquidWaste $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function datatableQuery(Request $request): array
    {
        $query = $this->model
            ->select([
                'liquid_wastes.id',
                'code',
                'liquid_wastes.name',
                'u.name as unit',
                'quantity',
                'liquid_wastes.description',
            ])->join('units as u', 'u.id', '=', 'liquid_wastes.unit_id');

        $columns = [
            'liquid_wastes.code',
            'liquid_wastes.name',
            'u.name',
            'liquid_wastes.quantity',
            'liquid_wastes.description',
        ];

        return [
            'query' => $query,
            'columns' => $columns
        ];
    }
}
