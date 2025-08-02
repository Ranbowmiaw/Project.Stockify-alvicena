<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index()
    {
        $lap3 = ActivityLog::with('user')->latest('logged_at')->get();
            $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.laporan.lap3.lapuser', compact('lap3'));
        } else {
            abort(403, 'Unauthorized role');
        }
        
        ActivityLog::create([
            'user_id'   => 1, 
            'activity'  => 'Coba manual insert',
            'role'      => 'Admin',
            'ip_address'=> request()->ip(),
            'logged_at' => now(),
        ]);

    }

    
}
