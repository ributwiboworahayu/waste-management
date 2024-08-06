<?php

namespace App\Services;

use App\Repositories\Interfaces\DatatablesRepositoryInterface;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;

class UnitService extends Service
{

    /**
     * don't change $this->mainInterface variable name
     * because used in extends service class
     */
    protected UnitRepositoryInterface $mainInterface;
    protected DatatablesRepositoryInterface $datatablesRepository;

    public function __construct(
        UnitRepositoryInterface       $mainInterface,
        DatatablesRepositoryInterface $datatablesRepository
    )
    {
        $this->mainInterface = $mainInterface;
        $this->datatablesRepository = $datatablesRepository;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function datatables(Request $request): array
    {
        $datatables = $this->mainInterface->datatableQuery($request);
        $query = $datatables['query'];
        $columns = $datatables['columns'];
        $actionRoutes = [
            'edit' => 'waste.units.update',
            'delete' => 'waste.units.delete'
        ];

        return $this->datatablesRepository->applyDatatables(
            'id',
            $request,
            $query,
            $columns,
            $actionRoutes
        );
    }

    public function store(Request $request): array
    {
        $units = $request->input('units');

        try {
            DB::transaction(function () use ($units) {
                foreach ($units as $unit) {
                    $this->mainInterface->create($unit);
                }
            });

            return ['status' => true, 'message' => 'Satuan berhasil ditambahkan.'];
        } catch (QueryException|Exception $e) {
            if ($e instanceof QueryException) {
                if (str_contains($e->getMessage(), 'already exists')) {
                    $errorString = $e->getMessage();
                    $startPos = strpos($errorString, 'values (') + strlen('values (');
                    $endPos = strpos($errorString, ',', $startPos); // Get the position of the first comma

                    $name = '';
                    if ($endPos !== false) {
                        // Mengambil substring
                        $name = substr($errorString, $startPos, $endPos - $startPos);
                    }

                    return ['status' => false, 'message' => "Satuan $name sudah ada."];
                }
            }
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
