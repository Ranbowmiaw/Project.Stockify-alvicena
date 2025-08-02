<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register()
    {
        return view('example.content.authentication.sign-up');
    }

    public function registersimpan(Request $request)
    {
        $this->authService->register($request->all());
        return redirect()->route('login');
    }

    public function login()
    {
        return view('example.content.authentication.sign-in');
    }

    public function loginAksi(Request $request)
    {
        $result = $this->authService->login($request);
        return $result ?: redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return redirect()->route('login');
    }
}
