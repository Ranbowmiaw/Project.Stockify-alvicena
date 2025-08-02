<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserService
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function findUserById($id)
    {
        return User::findOrFail($id);
    }

    public function updateUser($id, $data)
    {
        $user = User::findOrFail($id);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }

    public function updateProfilePicture($request)
    {
        $user = Auth::user();

        if ($user->profile_picture && $user->profile_picture !== 'default.jpeg') {
            File::delete(public_path('image/profiles/' . $user->profile_picture));
        }

        $image = $request->file('profile_picture');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('image/profiles'), $filename);

        $user->profile_picture = $filename;
        /** @var \App\Models\User $user */
        $user->save();

        return $filename;
    }

    public function deleteProfilePicture()
    {
        $user = Auth::user();

        if ($user->profile_picture && $user->profile_picture !== 'default.jpeg') {
            File::delete(public_path('image/profiles/' . $user->profile_picture));
            $user->profile_picture = 'default.jpeg';
            /** @var \App\Models\User $user */
            $user->save();
        }

        return true;
    }

    public function updateUserInfo($data)
    {
        $user = Auth::user();

        $user->name = $data['name'];
        if (!empty($data['email']) && $data['email'] !== $user->email) {
            $user->email = $data['email'];
        }

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        /** @var \App\Models\User $user */
        $user->save();
        return $user;
    }

    public function deleteCurrentAccount()
    {
        $user = Auth::user();
        Auth::logout();

        if ($user->profile_picture !== 'default.jpeg') {
            File::delete(public_path('image/profiles/' . $user->profile_picture));
        }
        /** @var \App\Models\User $user */
        $user->delete();
    }
}
