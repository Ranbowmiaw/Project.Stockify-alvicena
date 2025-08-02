<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
     public function index()
    {
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.settings');
        } elseif ($role === 'Manager Gudang') {
            return view('example.content.manager.settings');
        } elseif ($role === 'Staff Gudang') {
            return view('example.content.staff.settings');
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',   
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        setting(['site_name' => $request->site_name]);

        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/logo'), $filename);

            if (setting('site_logo') && File::exists(public_path('images/logo/' . setting('site_logo')))) {
                File::delete(public_path('images/logo/' . setting('site_logo')));
            }

            setting(['site_logo' => $filename]);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
