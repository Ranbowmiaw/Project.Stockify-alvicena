<?php

namespace App\Observers;

use App\Models\StockTransaction;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class StockTransactionObserver
{
    public function created(StockTransaction $stock)
    {
        $this->log("Menambahkan transaksi stok: {$stock->product_name} ({$stock->type})", 'stock_transaction');
    }

    public function updated(StockTransaction $stock)
    {
        $this->log("Mengubah transaksi stok: {$stock->product_name} (Status: " . ucfirst($stock->status) . ')', 'stock_transaction');
    }

    public function deleted(StockTransaction $stock)
    {
        $this->log("Menghapus transaksi stok: {$stock->product_name}", 'stock_transaction');
    }

    protected function log($activity, $type)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => $activity,
            'type' => $type,
            'role' => Auth::user()->role ?? 'Unknown',
            'ip_address' => request()->ip(),
            'logged_at' => now(),
        ]);
    }
}
