<?php

namespace App\Repositories\Eloquent;

use App\Models\ListWaste;
use App\Models\WasteTransaction;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use Carbon\Carbon;
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
                'units.name as unit',
                'u.name as approved_by',
                'approved_at as approved_date',
            ])
            ->join('users as u', 'u.id', '=', 'waste_transactions.approved_by')
            ->join('waste_transaction_details as wtd', 'wtd.id', '=', 'waste_transactions.waste_transaction_detail_id')
            ->join('list_wastes as lw', 'lw.id', '=', 'wtd.list_waste_id')
            ->join('units as unit', 'units.id', '=', 'wtd.unit_id')
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
            'units.name',
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
            COALESCE(COUNT(CASE WHEN list_wastes.is_b3 = TRUE AND waste_transactions.type = 'in' THEN 1 END), 0) AS total_b3_daily_in,
            COALESCE(COUNT(CASE WHEN list_wastes.is_b3 = TRUE AND waste_transactions.type = 'out' THEN 1 END), 0) AS total_b3_daily_out,
            COALESCE(COUNT(CASE WHEN list_wastes.is_b3 = TRUE THEN 1 END), 0) AS total_b3_daily,

            COALESCE(COUNT(CASE WHEN list_wastes.is_b3 = FALSE AND waste_transactions.type = 'in' THEN 1 END), 0) AS total_liquid_daily_in,
            COALESCE(COUNT(CASE WHEN list_wastes.is_b3 = FALSE AND waste_transactions.type = 'out' THEN 1 END), 0) AS total_liquid_daily_out,
            COALESCE(COUNT(CASE WHEN list_wastes.is_b3 = FALSE THEN 1 END), 0) AS total_liquid_daily
            ")
            ->join('waste_transaction_details', 'waste_transaction_details.id', '=', 'waste_transactions.waste_transaction_detail_id')
            ->join('list_wastes', 'list_wastes.id', '=', 'waste_transaction_details.list_waste_id')
            ->where('waste_transactions.approved_at', '>=', Carbon::today())
            ->first();


        return [
            'dailyTotalLiquidIn' => number_format($result->total_liquid_daily_in),
            'dailyTotalLiquidOut' => number_format($result->total_liquid_daily_out),
            'dailyTotalLiquid' => number_format($result->total_liquid_daily),
            'dailyTotalB3In' => number_format($result->total_b3_daily_in),
            'dailyTotalB3Out' => number_format($result->total_b3_daily_out),
            'dailyTotalB3' => number_format($result->total_b3_daily),
        ];
    }

    public function summaryQuery(Request $request): array
    {
        $query = ListWaste::select([
            'list_wastes.id',
            'list_wastes.name',
            DB::raw("(SELECT MAX(waste_transactions.approved_at) FROM waste_transactions
                  JOIN waste_transaction_details ON waste_transactions.waste_transaction_detail_id = waste_transaction_details.id
                  WHERE waste_transaction_details.list_waste_id = list_wastes.id) as trx_date"),
            DB::raw("COALESCE(SUM(CASE WHEN waste_transactions.type = 'in' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) as daily_in"),
            DB::raw("COALESCE(SUM(CASE WHEN waste_transactions.type = 'out' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) as daily_out"),
            'list_wastes.quantity as total',
            'units.name as unit',
            DB::raw("(SELECT waste_transaction_details.input_by FROM waste_transactions
                  JOIN waste_transaction_details ON waste_transactions.waste_transaction_detail_id = waste_transaction_details.id
                  WHERE waste_transaction_details.list_waste_id = list_wastes.id
                  ORDER BY waste_transactions.approved_at DESC LIMIT 1) as input_by")
        ])->leftJoin('waste_transaction_details', function ($join) {
            $join->on('waste_transaction_details.list_waste_id', '=', 'list_wastes.id')
                ->join('waste_transactions', 'waste_transactions.waste_transaction_detail_id', '=', 'waste_transaction_details.id')
                ->where('waste_transactions.approved_at', '>=', Carbon::today());
        })->leftJoin('units', 'units.id', '=', 'list_wastes.unit_id')
            ->when($request->input('waste'), function ($query) use ($request) {
                return $query->where('list_wastes.is_b3', ($request->input('waste') === 'b3'));
            });

        $groups = [
            'list_wastes.id',
            'list_wastes.name',
            'list_wastes.quantity',
            'units.name'
        ];

        $columns = [
            'list_wastes.name',
            'trx_date',
            'daily_in',
            'daily_out',
            'list_wastes.quantity',
            'units.name',
            'input_by'
        ];

        $searchValue = $request->input('search')['value'] ?? 0;
        $numberSearch = is_numeric($searchValue) ? $searchValue : 0;
        $dateSearch = Carbon::canBeCreatedFromFormat($searchValue, 'd F Y') ? Carbon::createFromFormat('d F Y', $searchValue)->format('Y-m-d') : '2000-01-01';
        $havingRaw = "COALESCE(SUM(CASE WHEN waste_transactions.type = 'in' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) = $numberSearch" .
            " OR COALESCE(SUM(CASE WHEN waste_transactions.type = 'out' THEN waste_transaction_details.conversion_value ELSE 0 END), 0) = $numberSearch" .
            " OR (SELECT waste_transaction_details.input_by FROM waste_transactions
                  JOIN waste_transaction_details ON waste_transactions.waste_transaction_detail_id = waste_transaction_details.id
                  WHERE waste_transaction_details.list_waste_id = list_wastes.id
                  ORDER BY waste_transactions.approved_at DESC LIMIT 1) = '$searchValue'" .
            " OR (SELECT MAX(waste_transactions.approved_at) FROM waste_transactions
                  JOIN waste_transaction_details ON waste_transactions.waste_transaction_detail_id = waste_transaction_details.id
                  WHERE waste_transaction_details.list_waste_id = list_wastes.id) = '$dateSearch'";

        return [
            'query' => $query,
            'columns' => $columns,
            'groupBy' => $groups,
            'havingRaw' => $havingRaw
        ];
    }
}
