<?php

namespace App\Http\Controllers;

use App\Services\LiquidService;
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
        return view('liquids.index');
    }

    public function datatables(Request $request)
    {
        $result = $this->liquidService->datatables($request);
        if ($result['ajax']) {
            return response()->json($this->liquidService->datatables($request));
        }
        return view('liquids.index');
    }
}
