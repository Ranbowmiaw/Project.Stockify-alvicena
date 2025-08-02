<?php

namespace App\Observers;

use App\Models\suppliers;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SupplierObserver
{
    public function created(suppliers $supplier)
    {
        $this->log('Menambahkan supplier: ' . $supplier->name);
    }

    public function updated(suppliers $supplier)
    {
        $this->log('Mengubah supplier: ' . $supplier->name);
    }

    public function deleted(suppliers $supplier)
    {
        $this->log('Menghapus supplier: ' . $supplier->name);
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
