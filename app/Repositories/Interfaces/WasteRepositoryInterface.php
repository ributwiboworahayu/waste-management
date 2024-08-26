<?php

namespace App\Repositories\Interfaces;

use LaravelEasyRepository\Repository;

interface WasteRepositoryInterface extends Repository
{

    public function getLastCode();
}
