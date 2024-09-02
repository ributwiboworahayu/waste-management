<?php

namespace App\Repositories\Eloquent;

use App\Models\ListWaste;
use App\Models\WasteTransaction;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
        return $this->model->withTrashed()->latest()->first()->code ?? 'WST000000';
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
                'lw.name as list_name',
                'waste_transactions.quantity',
                'unit.name as unit',
                'u.name as approved_by',
                'approved_at as approved_date',
            ])
            ->join('users as u', 'u.id', '=', 'waste_transactions.approved_by')
            ->join('waste_transaction_details as wtd', 'wtd.id', '=', 'waste_transactions.waste_transaction_detail_id')
            ->join('list_wastes as lw', 'lw.id', '=', 'wtd.list_waste_id')
            ->join('units as unit', 'unit.id', '=', 'wtd.unit_id')
            ->when($request->input('waste'), function ($query) use ($request) {
                return $query->where('is_b3', ($request->input('waste') === 'b3'));
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
        return $this->model->with([
            'detail',
            'detail.unit',
            'detail.listWaste',
        ])->find($id);
    }

    public function getDashboardData(): array
    {
        $result = WasteTransaction::selectRaw("
            COALESCE(SUM(CASE WHEN list_wastes.is_b3 = TRUE AND waste_transactions.type = 'in' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) AS total_b3_daily_in,
            COALESCE(SUM(CASE WHEN list_wastes.is_b3 = TRUE AND waste_transactions.type = 'out' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) AS total_b3_daily_out,
            COALESCE(SUM(CASE WHEN list_wastes.is_b3 = TRUE AND waste_transactions.type = 'in' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) -
            COALESCE(SUM(CASE WHEN list_wastes.is_b3 = TRUE AND waste_transactions.type = 'out' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) AS total_b3_daily,

            COALESCE(SUM(CASE WHEN list_wastes.is_b3 = FALSE AND waste_transactions.type = 'in' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) AS total_liquid_daily_in,
            COALESCE(SUM(CASE WHEN list_wastes.is_b3 = FALSE AND waste_transactions.type = 'out' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) AS total_liquid_daily_out,
            COALESCE(SUM(CASE WHEN list_wastes.is_b3 = FALSE AND waste_transactions.type = 'in' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) -
            COALESCE(SUM(CASE WHEN list_wastes.is_b3 = FALSE AND waste_transactions.type = 'out' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) AS total_liquid_daily
        ")
            ->join('waste_transaction_details', 'waste_transaction_details.id', '=', 'waste_transactions.waste_transaction_detail_id')
            ->join('list_wastes', 'list_wastes.id', '=', 'waste_transaction_details.list_waste_id')
            ->where('waste_transactions.approved_at', '>=', '2024-09-02')
            ->first();

        $totalSum = ListWaste::selectRaw("
            COALESCE(SUM(CASE WHEN is_b3 = TRUE THEN quantity ELSE 0 END), 0) AS total_b3,
            COALESCE(SUM(CASE WHEN is_b3 = FALSE THEN quantity ELSE 0 END), 0) AS total_liquid
        ")->first();

        return [
            'dailyTotalLiquidIn' => number_format($result->total_liquid_daily_in, 2, ',', '.'),
            'dailyTotalLiquidOut' => number_format($result->total_liquid_daily_out, 2, ',', '.'),
            'dailyTotalLiquid' => number_format($result->total_liquid_daily, 2, ',', '.'),
            'dailyTotalB3In' => number_format($result->total_b3_daily_in, 2, ',', '.'),
            'dailyTotalB3Out' => number_format($result->total_b3_daily_out, 2, ',', '.'),
            'dailyTotalB3' => number_format($result->total_b3_daily, 2, ',', '.'),
            'totalLiquid' => number_format($totalSum->total_liquid, 2, ',', '.'),
            'totalB3' => number_format($totalSum->total_b3, 2, ',', '.'),
        ];
    }
}
