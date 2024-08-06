<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Services\UnitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    protected UnitService $service;

    public function __construct(
        UnitService $unitService
    )
    {
        $this->service = $unitService;
    }

    public function units()
    {
        return view('units.index');
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(StoreUnitRequest $request)
    {
        $result = $this->service->store($request);
        if ($result['status']) {
            return redirect()->route('waste.units')->with('success', $result['message']);
        }
        return redirect()->back()->withErrors($result['message'])->withInput();
    }

    /**
     * @param $id
     * @param StoreUnitRequest $request
     * @return RedirectResponse
     */
    public function update($id, StoreUnitRequest $request): RedirectResponse
    {
        $result = $this->service->update($id, $request->toArray());
        if (!$result) {
            return redirect()->back()->with('error', 'Gagal mengubah data unit');
        }
        return redirect()->route('waste.units')->with('success', 'Berhasil mengubah data unit');
    }

    public function delete($id)
    {
        $result = $this->service->delete($id);
        if (!$result) {
            return redirect()->back()->with('error', 'Gagal menghapus data unit');
        }
        return redirect()->route('waste.units')->with('success', 'Berhasil menghapus data unit');
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function datatables(Request $request)
    {
        $result = $this->service->datatables($request);
        if ($result['ajax']) {
            return response()->json($this->service->datatables($request));
        }
        return redirect()->route('units.index');
    }
}
