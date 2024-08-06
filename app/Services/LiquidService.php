<?php

namespace App\Services;

use App\Repositories\Eloquent\DatatablesRepository;
use App\Repositories\Interfaces\LiquidRepositoryInterface;
use Illuminate\Http\Request;
use LaravelEasyRepository\Service;

class LiquidService extends Service
{

    /**
     * don't change $this->mainInterface variable name
     * because used in extends service class
     */
    protected LiquidRepositoryInterface $mainInterface;
    protected DatatablesRepository $datatablesRepository;

    public function __construct(
        LiquidRepositoryInterface $mainInterface,
        DatatablesRepository      $datatablesRepository
    )
    {
        $this->mainInterface = $mainInterface;
        $this->datatablesRepository = $datatablesRepository;
    }

    public function datatables(Request $request): array
    {
        $datatables = $this->mainInterface->datatableQuery($request);
        $query = $datatables['query'];
        $columns = $datatables['columns'];
        $actionRoutes = [
            'edit' => 'waste.liquid.update',
            'delete' => 'waste.liquid.delete'
        ];

        return $this->datatablesRepository->applyDatatables(
            'liquid_wastes.id',
            $request,
            $query,
            $columns,
            $actionRoutes
        );
    }
}
