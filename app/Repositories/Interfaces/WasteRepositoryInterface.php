<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface WasteRepositoryInterface extends Repository
{

    public function getLastCode();

    public function store(array $data);

    public function show($id);

    public function getDashboardData(): array;

    public function datatableQuery(Request $request);

    public function summaryQuery(Request $request): array;
}
