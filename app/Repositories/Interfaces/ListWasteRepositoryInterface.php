<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface ListWasteRepositoryInterface extends Repository
{

    public function datatableQuery(Request $request);

    public function getLatestListByIsB3($isB3);

    public function listWaste($isB3);
}
