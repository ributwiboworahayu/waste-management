<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrxRequest;
use App\Models\LiquidWaste;
use App\Services\WasteService;
use App\Traits\QueryExceptionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class WasteController extends Controller
{
    use QueryExceptionTrait;

    protected WasteService $wasteService;

    public function __construct(
        WasteService $wasteService
    )
    {
        $this->wasteService = $wasteService;
    }

    public function index()
    {
        return view('waste.index');
    }

    public function create()
    {
        $units = $this->wasteService->getUnits();
        $liquids = $this->wasteService->getLiquids();
        $codeName = $this->wasteService->generateCode();
        $error = self::unitOrLiquidEmpty($units, $liquids);
        return view('waste.create', compact(['liquids', 'codeName']))->with('error', $error);
    }

    public function store(StoreTrxRequest $request): RedirectResponse
    {
        $result = $this->wasteService->store($request);
        if ($result['error']) return redirect()->back()->withErrors($result['message'])->withInput();
        return redirect()->route('waste.index')->withSuccess($result['message']);
    }

    /**
     * @param LiquidWaste $liquidWaste
     * @return JsonResponse
     */
    public function getUnitByLiquidId(LiquidWaste $liquidWaste): JsonResponse
    {
        $result = $this->wasteService->getUnitByLiquid($liquidWaste);
        return response()->json($result);
    }
}
