<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(
        DashboardService $dashboardService
    )
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data = $this->dashboardService->getData();
        return view('dashboard', compact('data'));
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function datatables(Request $request)
    {
        $result = $this->dashboardService->datatables($request);
        if (!$result['ajax']) return redirect()->route('dashboard.index')->withErrors('Invalid request');
        return response()->json($result);
    }
}
