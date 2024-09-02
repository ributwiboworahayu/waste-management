<?php

namespace App\Services;

use App\Repositories\Interfaces\DatatablesRepositoryInterface;
use App\Repositories\Interfaces\ListWasteRepositoryInterface;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use App\Traits\QueryExceptionTrait;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;

class ListWasteService extends Service
{
    use QueryExceptionTrait;

    /**
     * don't change $this→mainInterface variable name
     * because used in extent service class
     */
    protected ListWasteRepositoryInterface $mainInterface;
    protected DatatablesRepositoryInterface $datatablesRepository;
    protected UnitRepositoryInterface $unitRepository;

    public function __construct(
        ListWasteRepositoryInterface  $mainInterface,
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
        $lists = $request->input('lists');
        $isB3 = $request->input('waste') === 'b3';

        try {
            DB::transaction(function () use ($lists, $isB3) {
                foreach ($lists as $list) {
                    $this->mainInterface->create([
                        'name' => $list['name'],
                        'unit_id' => $list['unitName'],
                        'is_b3' => $isB3,
                        'code' => $list['codeName'],
                        'description' => $list['description']
                    ]);
                }
            });

            return [
                'status' => true,
                'message' => 'Berhasil menambahkan ' . count($lists) . ' data limbah'
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
            'edit' => 'waste.list.update',
            'delete' => 'waste.list.delete'
        ];

        return $this->datatablesRepository->applyDatatables(
            'id',
            $request,
            $query,
            $columns,
            $actionRoutes
        );
    }

    public function generateCode($type): string
    {
        $prefix = $type === 'b3' ? 'B3' : 'LQ';
        $isB3 = $type === 'b3';
        $latestList = $this->mainInterface->getLatestListByIsB3($isB3);

        if ($latestList) {
            $latestCode = $latestList->code;
            $latestNumber = (int)substr($latestCode, -4);
            $latestNumber++;
            return $prefix . str_pad($latestNumber, 4, '0', STR_PAD_LEFT);
        }

        return $prefix . '0001';
    }
}
