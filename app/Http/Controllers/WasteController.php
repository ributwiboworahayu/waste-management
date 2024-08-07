<?php

namespace App\Http\Controllers;

use App\Services\WasteService;
use App\Traits\QueryExceptionTrait;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        return view('waste.index');
    }

    public function create()
    {
        $units = $this->wasteService->getUnits();
        $error = self::unitEmpty($units);
        return view('waste.create', compact('units'))->with('error', $error);
    }
}
