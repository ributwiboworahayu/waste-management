<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLiquidRequest;
use App\Http\Requests\UpdateLiquidRequest;
use App\Services\LiquidService;
use App\Traits\QueryExceptionTrait;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LiquidController extends Controller
{

    use QueryExceptionTrait;

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
        $error = self::unitEmpty($units);
        return view('liquids.index', compact('units'))->with('error', $error);
    }

    public function create(Request $request)
    {
        $units = $this->liquidService->getUnits();
        $error = self::unitEmpty($units);
        return view('liquids.create', array_merge($request->query(), compact('units')))
            ->with('error', $error);
    }

    /**
     * @param StoreLiquidRequest $request
     * @return RedirectResponse
     */
    public function store(StoreLiquidRequest $request): RedirectResponse
    {
        $result = $this->liquidService->store($request);
        if ($result['status']) return redirect()->route('waste.liquid', $request->query())
            ->with('success', $result['message']);
        return redirect()->back()->withErrors($result['message'])->withInput();
    }

    /**
     * @param $id
     * @param UpdateLiquidRequest $request
     * @return RedirectResponse
     */
    public function update($id, UpdateLiquidRequest $request): RedirectResponse
    {
        $data = $request->post();
        try {
            $result = $this->liquidService->update($id, $data);
            if (!$result) return redirect()->back()->with('error', 'Gagal mengubah data liquid')->withInput();
        } catch (Exception $e) {
            $res = self::alreadyExists($e);
            return redirect()->back()->with('error', $res['message'])->withInput();
        }
        return redirect()->route('waste.liquid')->with('success', 'Berhasil mengubah data cairan');
    }

    public function delete($id)
    {
        try {
            $result = $this->liquidService->delete($id);
            if (!$result) return redirect()->back()->with('error', 'Gagal menghapus data liquid');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatables(Request $request)
    {
        $result = $this->liquidService->datatables($request);
        if ($result['ajax']) return response()->json($result);
        return redirect()->route('waste.liquid')->with('error', 'Terjadi kesalahan');
    }
}
