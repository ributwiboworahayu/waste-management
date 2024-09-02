<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(
        DashboardService $dashboardService
    )
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $data = $this->dashboardService->getData();
        $dailyTotalB3 = $data['dailyTotalB3'];
        $dailyTotalLiquid = $data['dailyTotalLiquid'];
        $totalLiquid = $data['totalLiquid'];
        $totalB3 = $data['totalB3'];
        return view('dashboard', compact(['dailyTotalB3', 'dailyTotalLiquid', 'totalLiquid', 'totalB3']));
    }
}
