<?php

namespace App\Repositories\Interfaces;

use LaravelEasyRepository\Repository;

interface WasteTransactionDetailRepositoryInterface extends Repository
{

    public function store(array $data);
}
