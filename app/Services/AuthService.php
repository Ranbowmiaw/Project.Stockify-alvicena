<?php

namespace App\Services;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    public function register(array $data)
    {
        Validator::make($data, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role'     => 'required|in:Admin,Staff Gudang,Manager Gudang',
        ])->validate();

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);
    }

    public function login($request)
    {
        Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ])->validate();

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email'    => 'Email atau password salah.',
                'password' => 'Email atau password salah.',
            ])->withInput();
        }

        $request->session()->regenerate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        ActivityLog::create([
            'user_id'   => $user->id,
            'activity'  => 'Login',
            'role'      => $user->role,
            'ip_address'=> $request->ip(),
            'logged_at' => now(),
        ]);

        $user->update([
            'status'     => 'aktif',
            'last_seen'  => now(),
        ]);

        return null;
    }

    public function logout($request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user) {
            $user->update([
                'status'    => 'nonaktif',
                'last_seen' => now(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
