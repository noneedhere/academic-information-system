<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
    ) {}

    /**
     * Display the role-specific dashboard.
     */
    public function index(): View
    {
        $data = $this->dashboardService->getData();

        return view('dashboard.index', $data);
    }
}
