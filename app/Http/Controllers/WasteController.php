<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrxRequest;
use App\Models\ListWaste;
use App\Services\WasteService;
use App\Traits\QueryExceptionTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WasteController extends Controller
{
    use QueryExceptionTrait;

    protected WasteService $wasteService;

    /**
     * @param WasteService $wasteService
     */
    public function __construct(
        WasteService $wasteService
    )
    {
        $this->wasteService = $wasteService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('waste.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        $units = $this->wasteService->getUnits();

        $waste = $request->input('waste');
        $lists = $this->wasteService->getLiquids($waste);
        $codeName = $this->wasteService->generateCode();
        $error = self::unitOrLiquidEmpty($units, $lists);
        return view('waste.create', compact(['lists', 'codeName']))->with('error', $error);
    }

    /**
     * @param StoreTrxRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTrxRequest $request): RedirectResponse
    {
        $result = $this->wasteService->store($request);
        if ($result['error']) return redirect()->back()->withErrors($result['message'])->withInput();
        return redirect()->route('waste.index', $request->query())->withSuccess($result['message']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $result = $this->wasteService->show($id);
        return response()->json($result);
    }

    /**
     * @param ListWaste $liquidWaste
     * @return JsonResponse
     */
    public function getUnitByLiquidId(ListWaste $liquidWaste): JsonResponse
    {
        $result = $this->wasteService->getUnitByLiquid($liquidWaste);
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function datatables(Request $request)
    {
        $result = $this->wasteService->datatables($request);
        if ($result['ajax']) return response()->json($result);
        return redirect()->route('waste.index')->with('error', 'Invalid request');
    }
}
