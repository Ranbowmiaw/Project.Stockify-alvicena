<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    public function created(Category $category)
    {
        $this->log('Menambahkan kategori: ' . $category->name);
    }

    public function updated(Category $category)
    {
        $this->log('Mengubah kategori: ' . $category->name);
    }

    public function deleted(Category $category)
    {
        $this->log('Menghapus kategori: ' . $category->name);
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
