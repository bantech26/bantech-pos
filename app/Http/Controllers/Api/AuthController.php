<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login secara manual untuk membuat Session Web
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();
            
            // Buat token untuk API (Opsional jika hanya pakai Blade)
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login Berhasil',
                'access_token' => $token,
                'user' => $user
            ], 200);
        }

        return response()->json(['message' => 'Email atau Password salah!'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin' // Sesuai dengan UserSeeder Anda
        ]);

        return response()->json(['message' => 'User berhasil didaftarkan'], 201);
    }

    public function logout(Request $request)
    {
        // 1. Hapus Token API (Sanctum)
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        // 2. Hapus Session Web (PENTING!)
        \Illuminate\Support\Facades\Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Berhasil logout']);
    }
}
