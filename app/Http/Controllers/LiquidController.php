<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLiquidRequest;
use App\Services\LiquidService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LiquidController extends Controller
{
    protected LiquidService $liquidService;

    public function __construct(
        LiquidService $liquidService
    )
    {
        $this->liquidService = $liquidService;
    }

    public function liquid()
    {
        $units = $this->liquidService->getUnits();
        return view('liquids.index', compact('units'));
    }

    public function create()
    {
        $units = $this->liquidService->getUnits();
        return view('liquids.create', compact('units'));
    }

    /**
     * @param StoreLiquidRequest $request
     * @return RedirectResponse
     */
    public function store(StoreLiquidRequest $request): RedirectResponse
    {
        $result = $this->liquidService->store($request);
        if ($result['status']) {
            return redirect()->route('waste.liquid')->with('success', $result['message']);
        }
        return redirect()->back()->withErrors($result['message'])->withInput();
    }

    public function datatables(Request $request)
    {
        $result = $this->liquidService->datatables($request);
        if ($result['ajax']) {
            return response()->json($result);
        }
        return view('liquids.index');
    }
}
