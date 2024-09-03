<?php

namespace App\Services;

use App\Repositories\Interfaces\DatatablesRepositoryInterface;
use App\Repositories\Interfaces\WasteRepositoryInterface;
use Illuminate\Http\Request;
use LaravelEasyRepository\Service;

class DashboardService extends Service
{


    protected WasteRepositoryInterface $wasteTransactionRepository;
    protected DatatablesRepositoryInterface $datatablesRepository;

    public function __construct(
        WasteRepositoryInterface      $wasteTransactionRepository,
        DatatablesRepositoryInterface $datatablesRepository
    )
    {
        $this->wasteTransactionRepository = $wasteTransactionRepository;
        $this->datatablesRepository = $datatablesRepository;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->wasteTransactionRepository->getDashboardData();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function datatables(Request $request): array
    {
        $eloquent = $this->wasteTransactionRepository->summaryQuery($request);
        $query = $eloquent['query'];
        $columns = $eloquent['columns'];
        $groupBy = $eloquent['groupBy'];
        $havingRaw = $eloquent['havingRaw'];

        return $this->datatablesRepository->applyDatatables(
            'id',
            $request,
            $query,
            $columns,
            [],
            $groupBy,
            $havingRaw
        );
    }
}
