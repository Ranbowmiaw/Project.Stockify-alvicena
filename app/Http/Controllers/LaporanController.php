<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LaporanService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function lapstock1()
    {
        $lap1 = $this->laporanService->getLaporanStok();
        $role = Auth::user()->role;

        if ($role === 'Admin') {
            return view('example.content.admin.laporan.lap1.lapstock', compact('lap1'));
        } elseif ($role === 'Manager Gudang') {
            return view('example.content.manager.laporan.lap1.lapstock', compact('lap1'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function lapstock2()
    {
        $lap2 = $this->laporanService->getLaporanTransaksi();
        $role = Auth::user()->role;

        if ($role === 'Admin') {
            return view('example.content.admin.laporan.lap2.laptransaksi', compact('lap2'));
        } elseif ($role === 'Manager Gudang') {
            return view('example.content.manager.laporan.lap2.laptransaksi', compact('lap2'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function export1()
    {
        $this->authorizeRole(['admin', 'manager gudang']);
        $data = $this->laporanService->getExportData();
        $role = strtolower(Auth::user()->role);

        $view = $role === 'admin'
            ? 'example.content.admin.laporan.export1'
            : 'example.content.manager.laporan.export1';

        $pdf = PDF::loadView($view, compact('data'));
        return $pdf->download('laporan_stok.pdf');
    }

    public function export2($id)
    {
        $this->authorizeRole(['admin', 'manager gudang']);
        $row = $this->laporanService->getExportDetail($id);
        $role = strtolower(Auth::user()->role);

        $view = $role === 'admin'
            ? 'example.content.admin.laporan.export2'
            : 'example.content.manager.laporan.export2';

        $pdf = PDF::loadView($view, compact('row'));
        return $pdf->download('laporan_transaksi_' . $row->product->name . '.pdf');
    }

    protected function authorizeRole(array $allowedRoles)
    {
        $userRole = strtolower(Auth::user()->role);
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized access. Your role is: ' . Auth::user()->role);
        }
    }
}
