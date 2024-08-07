<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
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

    public function create(Request $request)
    {
        return view('units.create', $request->query());
    }

    /**
     * @param StoreUnitRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUnitRequest $request): RedirectResponse
    {
        $result = $this->service->store($request);
        if ($result['status']) {
            return redirect()->route('waste.units', $request->query())->with('success', $result['message']);
        }
        return redirect()->back()->withErrors($result['message'])->withInput();
    }

    /**
     * @param $id
     * @param UpdateUnitRequest $request
     * @return RedirectResponse
     */
    public function update($id, UpdateUnitRequest $request): RedirectResponse
    {
        $result = $this->service->update($id, $request->toArray());
        if (!$result) {
            return redirect()->back()->with('error', 'Gagal mengubah data unit')->withInput();
        }

        return redirect()->route('waste.units', $request->query())
            ->with('success', 'Berhasil mengubah data unit');
    }

    public function delete($id): RedirectResponse
    {
        try {
            $result = $this->service->delete($id);
            if (!$result) {
                return redirect()->back()->with('error', 'Gagal menghapus data unit');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('waste.units', request()->query())
            ->with('success', 'Berhasil menghapus data unit');
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function datatables(Request $request)
    {
        $result = $this->service->datatables($request);
        if ($result['ajax']) {
            return response()->json($result);
        }
        return redirect()->route('units.index');
    }
}
