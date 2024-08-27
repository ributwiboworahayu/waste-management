<?php

namespace App\Services;

use App\Repositories\Interfaces\DatatablesRepositoryInterface;
use App\Repositories\Interfaces\LiquidRepositoryInterface;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use App\Traits\QueryExceptionTrait;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;

class LiquidService extends Service
{
    use QueryExceptionTrait;

    /**
     * don't change $this→mainInterface variable name
     * because used in extent service class
     */
    protected LiquidRepositoryInterface $mainInterface;
    protected DatatablesRepositoryInterface $datatablesRepository;
    protected UnitRepositoryInterface $unitRepository;

    public function __construct(
        LiquidRepositoryInterface     $mainInterface,
        DatatablesRepositoryInterface $datatablesRepository,
        UnitRepositoryInterface       $unitRepository
    )
    {
        $this->mainInterface = $mainInterface;
        $this->datatablesRepository = $datatablesRepository;
        $this->unitRepository = $unitRepository;
    }

    /**
     * @return Collection|null
     */
    public function getUnits(): ?Collection
    {
        return $this->unitRepository->all()->makeHidden(['created_at', 'updated_at', 'deleted_at']);
    }

    public function store(Request $request): array
    {
        $liquids = $request->input('liquids');

        try {
            DB::transaction(function () use ($liquids) {
                foreach ($liquids as $liquid) {
                    $this->mainInterface->create([
                        'name' => $liquid['name'],
                        'unit_id' => $liquid['unitName'],
                        'code' => $liquid['codeName'],
                        'description' => $liquid['description']
                    ]);
                }
            });

            return [
                'status' => true,
                'message' => 'Berhasil menambahkan cairan'
            ];
        } catch (QueryException|Exception $e) {
            return self::alreadyExists($e);
        }
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
            'id',
            $request,
            $query,
            $columns,
            $actionRoutes
        );
    }
}
