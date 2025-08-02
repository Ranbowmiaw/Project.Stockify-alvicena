<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class StockSettingObserver
{
    public function updated(Product $setting)
    {
         $productName = $setting->product ? $setting->product->name : 'Produk tidak ditemukan';

        $this->log("Memperbarui stok minimum untuk produk: {$productName} menjadi {$setting->minimum_stock}", 'stock_setting');
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
