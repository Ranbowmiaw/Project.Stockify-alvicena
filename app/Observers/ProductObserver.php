<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    public function created(Product $product)
    {
        $this->log('Menambahkan produk: ' . $product->name);
    }

    public function updated(Product $product)
    {
        $this->log('Mengubah produk: ' . $product->name);
    }

    public function deleted(Product $product)
    {
        $this->log('Menghapus produk: ' . $product->name);
    }

    protected function log($activity)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => $activity,
            'role' => Auth::user()->role ?? 'Unknown',
            'ip_address' => request()->ip(),
            'logged_at' => now(),
        ]);
    }
}
