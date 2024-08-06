<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface DatatablesRepositoryInterface extends Repository
{

    public function applyDatatables(
        string  $tableIdColumnName,
        Request $request,
                $query,
        array   $columns,
        array   $actionRoutes = [],
        array   $groupBy = [],
        string  $havingRaw = '',
        bool    $hideIdColumn = true
    ): array;
}
