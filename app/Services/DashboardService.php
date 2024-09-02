<?php

namespace App\Services;

use App\Repositories\Interfaces\DashboardRepositoryInterface;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use LaravelEasyRepository\Service;

class DashboardService extends Service
{


    protected WasteRepositoryInterface $wasteTransactionRepository;

    public function __construct(
        WasteRepositoryInterface $wasteTransactionRepository
    )
    {
        $this->wasteTransactionRepository = $wasteTransactionRepository;
    }

    public function getData(): array
    {
        return $this->wasteTransactionRepository->getDashboardData();
    }
}
