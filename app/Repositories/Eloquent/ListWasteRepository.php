<?php

namespace App\Repositories\Eloquent;

use App\Models\ListWaste;
use App\Repositories\Interfaces\ListWasteRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use LaravelEasyRepository\Implementations\Eloquent;

class ListWasteRepository extends Eloquent implements ListWasteRepositoryInterface
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this→model variable name
     * @property Model|mixed $model;
     */
    protected ListWaste $model;

    public function __construct(ListWaste $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function datatableQuery(Request $request): array
    {
        $isB3 = $request->input('type') === 'b3';
        $query = $this->model
            ->select([
                'list_wastes.id',
                'code',
                'list_wastes.name',
                'u.name as unit',
                'quantity',
                'list_wastes.description',
            ])->join('units as u', 'u.id', '=', 'list_wastes.unit_id')
            ->where('is_b3', $isB3);

        $columns = [
            'list_wastes.code',
            'list_wastes.name',
            'u.name',
            'list_wastes.quantity',
            'list_wastes.description',
        ];

        return [
            'query' => $query,
            'columns' => $columns
        ];
    }

    public function getLatestListByIsB3($isB3)
    {
        return $this->model->withTrashed()->where('is_b3', $isB3)->latest()->first();
    }

    public function listWaste($isB3)
    {
        return $this->model->where('is_b3', $isB3)->get()
            ->map(function ($liquid) {
                return [
                    'id' => $liquid->id,
                    'text' => $liquid->name,
                    'unit' => $liquid->unit->name,
                    'unit_id' => $liquid->unit->id,
                    'is_b3' => $liquid->is_b3,
                ];
            });
    }
}
