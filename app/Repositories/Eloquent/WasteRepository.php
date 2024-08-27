<?php

namespace App\Repositories\Eloquent;

use App\Models\WasteTransaction;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Implementations\Eloquent;

class WasteRepository extends Eloquent implements WasteRepositoryInterface
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this→model variable name
     * @property Model|mixed $model;
     */
    protected WasteTransaction $model;

    public function __construct(WasteTransaction $model)
    {
        $this->model = $model;
    }

    public function getLastCode()
    {
        return $this->model->latest()->first()->code ?? 'WST0000';
    }

    public function store(array $data)
    {
        return $this->model->create([
            'code' => $data['code'],
            'waste_transaction_detail_id' => $data['waste_transaction_detail_id'],
            'quantity' => $data['quantity'],
            'type' => $data['type'],
            'approved_by' => $data['approved_by'],
            'approved_at' => $data['approved_at'],
            'status' => $data['status'],
            'description' => $data['description'],
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function datatableQuery(Request $request): array
    {
        $query = $this->model
            ->select([
                'waste_transactions.id',
                'waste_transactions.code',
                'type',
                'lw.name as liquid_name',
                'waste_transactions.quantity',
                DB::raw("CASE
                    WHEN wtd.unit_conversion_id IS NULL THEN lw.unit_id
                    ELSE uc.to_unit_id
                 END as unit_id"),
                'unit.symbol as unit',
                'u.name as approved_by',
                'approved_at as approved_date',
            ])
            ->join('users as u', 'u.id', '=', 'waste_transactions.approved_by')
            ->join('waste_transaction_details as wtd', 'wtd.id', '=', 'waste_transactions.waste_transaction_detail_id')
            ->leftJoin('unit_conversions as uc', 'uc.id', '=', 'wtd.unit_conversion_id')
            ->join('liquid_wastes as lw', 'lw.id', '=', 'wtd.liquid_waste_id')
            ->join('units as unit', function ($join) {
                $join->on('unit.id', '=', DB::raw("COALESCE(uc.to_unit_id, lw.unit_id)"));
            })
            ->when($request->input('type'), function ($query) use ($request) {
                return $query->where('type', $request->input('type'));
            });

        $columns = [
            'waste_transactions.code',
            'waste_transactions.type',
            'lw.name',
            'waste_transactions.quantity',
            'unit.name',
            'u.name',
            'waste_transactions.approved_at',
        ];

        return [
            'query' => $query,
            'columns' => $columns
        ];
    }

    public function show($id)
    {
        return $this->model->with('detail')->find($id);
    }
}
