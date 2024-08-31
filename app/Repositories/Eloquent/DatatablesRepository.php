<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\DatatablesRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\Implementations\Eloquent;

class DatatablesRepository extends Eloquent implements DatatablesRepositoryInterface
{

    /**
     * @param string $tableIdColumnName
     * @param Request $request
     * @param $query
     * @param array $columns
     * @param array $actionRoutes
     * @param array $groupBy
     * @param string $havingRaw
     * @param bool $hideIdColumn
     * @return array
     */
    public function applyDataTables(
        string  $tableIdColumnName,
        Request $request,
                $query,
        array   $columns,
        array   $actionRoutes = [],
        array   $groupBy = [],
        string  $havingRaw = '',
        bool    $hideIdColumn = true
    ): array
    {
        if ($request->ajax() || config('app.debug')) {
            // Ambil parameter pencarian, pengurutan, dan paginasi
            $searchValue = $request->input('search.value');
            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderDirection = $request->input('order.0.dir', 'asc');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);


            // Mapping nama kolom yang akan diurutkan
            $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];

            if (config('app.debug')) Log::info('orderColumn: ' . $orderColumn);

            $cloneQuery = clone $query;
            // Terapkan filter pencarian
            if (!empty($searchValue)) {
                $query->where(function ($query) use ($searchValue, $columns) {
                    foreach ($columns as $column) {
                        if (str_contains($column, '.')) {
                            $query->orWhere($column, 'ilike', "%$searchValue%");
                        }
                    }
                });
            }

            // group by
            if (!empty($groupBy)) {
                $query->groupBy($groupBy);
            }

            // for purpose debug, if any query error it will show
            if (config('app.debug')) {
                $query2 = clone $cloneQuery;
                $query2->get();
            }

            // Total records
            $totalRecords = self::totalRecords($query);

            // if it has had raw
            if (!empty($havingRaw)) {
                if ($totalRecords == 0) {
                    // use having raw
                    $query = $cloneQuery->havingRaw($havingRaw);

                    if (!empty($groupBy)) {
                        $query->groupBy($groupBy);
                    }

                    $totalRecords = self::totalRecords($query);
                }
            }

            // Terapkan pengurutan
            $query->orderBy($orderColumn, $orderDirection);

            // Ambil data yang sudah difilter dan diurutkan
            $filteredData = $query->offset($start)->limit($length)->get();

            // Membuat format data untuk DataTables
            return [
                'ajax' => true,
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => collect($filteredData)->map(function ($item, $index) use ($hideIdColumn, $actionRoutes, $tableIdColumnName, $start) {
                    $id = $item->$tableIdColumnName ?? null;

                    // Hitung nomor urutan DT_RowIndex
                    $rowIndex = $start + $index + 1;

                    // Tambahkan DT_RowIndex ke dalam array data
                    $item->DT_RowIndex = $rowIndex;

                    if ($id) {
                        $actions = [];

                        if (isset($actionRoutes['detail'])) {
                            $params = $actionRoutes['detailParams'] ?? [];
                            $actions[] = [
                                'name' => 'detail',
                                'route' => route($actionRoutes['detail'], array_merge([$tableIdColumnName => $id], $params)),
                                'label' => 'Detail',
                                'icon' => 'bi bi-eye',
                                'class' => 'btn-info btn-detail'
                            ];
                        }

                        if (isset($actionRoutes['edit'])) {
                            $params = $actionRoutes['editParams'] ?? [];
                            $actions[] = [
                                'name' => 'edit',
                                'route' => route($actionRoutes['edit'], array_merge([$tableIdColumnName => $id], $params)),
                                'label' => 'Edit',
                                'icon' => 'bi bi-pencil',
                                'class' => 'btn-warning btn-edit'
                            ];
                        }

                        if (isset($actionRoutes['delete'])) {
                            $params = $actionRoutes['deleteParams'] ?? [];
                            $actions[] = [
                                'name' => 'delete',
                                'route' => route($actionRoutes['delete'], array_merge([$tableIdColumnName => $id], $params)),
                                'label' => 'Delete',
                                'icon' => 'bi bi-trash',
                                'class' => 'btn-danger btn-delete'
                            ];
                        }

                        $item->actions = $actions;
                    }

                    if ($hideIdColumn) {
                        unset($item->$tableIdColumnName);
                    }
                    return $item;
                })
            ];
        }

        return ['ajax' => false, 'data' => []];
    }

    /**
     * @param $query
     * @return int
     */
    private static function totalRecords($query): int
    {
        // Total records from a query
        $totalRecordQuery = DB::table(DB::raw("({$query->toSql()}) as sub"));
        try {
            return $totalRecordQuery->mergeBindings($query->getQuery())->count();
        } catch (Exception $ex) {
            return $totalRecordQuery->mergeBindings($query)->count();
        }
    }
}
