<?php

namespace App\Services;

use App\Models\StockTransaction;

class LaporanService
{
    public function getLaporanStok()
    {
        return StockTransaction::with(['product', 'product.category', 'latestOpname', 'user'])
            ->oldest()
            ->get();
    }

    public function getLaporanTransaksi()
    {
        return StockTransaction::with(['product', 'product.category', 'user'])
            ->oldest()
            ->get();
    }

    public function getExportData()
    {
        return StockTransaction::with(['product', 'product.category', 'user'])
            ->latest()
            ->get();
    }

    public function getExportDetail($id)
    {
        return StockTransaction::with(['product', 'product.category', 'user'])
            ->findOrFail($id);
    }
}
