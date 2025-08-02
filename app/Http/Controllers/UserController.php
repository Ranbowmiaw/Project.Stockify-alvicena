<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function users()
    {
        $this->authorizeRole('Admin');

        $userss = $this->userService->getAllUsers();
        return view('example.content.admin.user_log.userlogg', compact('userss'));
    }

    public function edit($id)
    {
        $this->authorizeRole('Admin');

        $user = $this->userService->findUserById($id);
        return view('example.content.admin.user_log.userloggedit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeRole('Admin');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$id",
            'role' => 'required|string',
            'password' => 'nullable|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $this->userService->updateUser($id, $validated);

        return redirect()->route('user')->with('success', 'User updated.');
    }

    public function hapus($id)
    {
        $this->authorizeRole('Admin');

        $this->userService->deleteUser($id);

        return redirect()->route('user')->with('success', 'User deleted.');
    }

    public function settings()
    {
        $this->authorizeRole('Admin');

        $user = Auth::user();
        return view('example.content.admin.settings', compact('user'));
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:800',
        ]);

        $this->userService->updateProfilePicture($request);

        return redirect()->route('settings')->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function deleteProfilePicture()
    {
        $this->userService->deleteProfilePicture(Auth::user());

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }

    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $this->userService->updateUser($user->id, $validated);

        return redirect()->route('settings')->with('success', 'Data berhasil diperbarui.');
    }

    public function deleteAccount()
    {
        $user = Auth::user();
        Auth::logout();

        $this->userService->deleteUser($user->id);

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }

    private function authorizeRole($role)
    {
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized role');
        }
    }
}
