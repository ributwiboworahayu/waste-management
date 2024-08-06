<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface UnitRepositoryInterface extends Repository
{

    public function datatableQuery(Request $request);
}
