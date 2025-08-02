<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $role = Auth::user()->role;
        $data = $this->dashboardService->getDashboardData($role);

        if ($role === 'Admin') {
            return view('example.content.admin.index', array_merge($data, [
                'title' => 'Dashboard',
            ]));
        } elseif ($role === 'Manager Gudang') {
            $filteredProducts = $data['products']->filter(fn ($p) => $p->status_stok === 'Kurang');
            return view('example.content.manager.index', array_merge($data, [
                'title' => 'Dashboard',
                'minimumStockProducts' => $filteredProducts,
            ]));
        } elseif ($role === 'Staff Gudang') {
            return view('example.content.staff.index', array_merge($data, [
                'title' => 'Dashboard',
            ]));
        } else {
            abort(403, 'Unauthorized role');
        }
    }
}
