<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLiquidRequest;
use App\Http\Requests\UpdateLiquidRequest;
use App\Services\ListWasteService;
use App\Traits\QueryExceptionTrait;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ListWasteController extends Controller
{

    use QueryExceptionTrait;

    protected ListWasteService $liquidService;

    public function __construct(
        ListWasteService $liquidService
    )
    {
        $this->liquidService = $liquidService;
    }

    public function liquid()
    {
        $units = $this->liquidService->getUnits();
        $error = self::unitEmpty($units);
        return view('waste-list.index', array_merge(request()->query(), compact('units')))
            ->with('error', $error);
    }

    public function create(Request $request)
    {
        $isAdministrator = $request->isAdministrator;
        if (!$isAdministrator) return redirect()->route('index')->with('error', 'Anda tidak memiliki akses');

        $units = $this->liquidService->getUnits();
        $error = self::unitEmpty($units);
        $codeName = $this->liquidService->generateCode($request->query('waste'));
        return view('waste-list.create', array_merge($request->query(), compact(['units', 'codeName'])))
            ->with('error', $error);
    }

    /**
     * @param StoreLiquidRequest $request
     * @return RedirectResponse
     */
    public function store(StoreLiquidRequest $request): RedirectResponse
    {
        $isAdministrator = $request->isAdministrator;
        if (!$isAdministrator) return redirect()->route('index')->with('error', 'Anda tidak memiliki akses');

        $result = $this->liquidService->store($request);
        if (!$result['status']) return redirect()->back()->withErrors($result['message'])->withInput();
        return ($request->input('new') == 1) ? redirect()->route('waste.create', $request->query())->with('success', $result['message']) :
            redirect()->route('waste.list', $request->query())->with('success', $result['message']);
    }

    /**
     * @param $id
     * @param UpdateLiquidRequest $request
     * @return RedirectResponse
     */
    public function update($id, UpdateLiquidRequest $request): RedirectResponse
    {
        $isAdministrator = $request->isAdministrator;
        if (!$isAdministrator) return redirect()->route('index')->with('error', 'Anda tidak memiliki akses');

        $data = $request->post();
        try {
            $result = $this->liquidService->update($id, $data);
            if (!$result) return redirect()->back()->with('error', 'Gagal mengubah data liquid')->withInput();
        } catch (Exception $e) {
            $res = self::alreadyExists($e);
            return redirect()->back()->with('error', $res['message'])->withInput();
        }
        return redirect()->route('waste.list')->with('success', 'Berhasil mengubah data cairan');
    }

    public function delete($id): RedirectResponse
    {
        try {
            $result = $this->liquidService->delete($id);
            if (!$result) return redirect()->back()->with('error', 'Gagal menghapus data liquid');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('waste.list')->with('success', 'Berhasil menghapus data cairan');
    }

    public function datatables(Request $request)
    {
        $result = $this->liquidService->datatables($request);
        if ($result['ajax']) return response()->json($result);
        return redirect()->route('waste.list')->with('error', 'Terjadi kesalahan');
    }
}
