<?php

namespace App\Observers;

use App\Models\StockOpname;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class StockOpnameObserver
{
    public function created(StockOpname $opname)
    {
        $this->log("Melakukan stok opname pada: {$opname->product->name} (Jumlah aktual: {$opname->actual_quantity})", 'stock_opname');
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


