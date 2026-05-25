<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nim' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Register berhasil',
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $avatarPath = $user->avatar;

        if ($request->hasFile('avatar')) {

            $avatarPath = $request->file('avatar')
                ->store('avatars', 'public');
        }

        $user->update([
            'name' => $request->name,
            'prodi' => $request->prodi,
            'angkatan' => $request->angkatan,
            'bio' => $request->bio,
            'avatar' => $avatarPath,
        ]);

        return response()->json([
            'message' => 'Profile berhasil diupdate',
            'user' => $user
        ]);
    }

    public function searchUser(Request $request)
    {
        $query = $request->query('query');

        return User::where('name', 'LIKE', "%{$query}%")
            ->get();
    }
}