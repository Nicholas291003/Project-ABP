<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lavel\Sactum\HasApiTokens;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input dari Flutter
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Cek apakah email & password cocok dengan database
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'Email atau password salah, mohon periksa kembali!'
            ], 401);
        }

        // 3. Jika cocok, ambil data user & buat token akses keamanan
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Selamat datang, ' . $user->name,
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function register(Request $request)
    {
        // 1. Validasi data kiriman dari Flutter
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' artinya butuh input password_confirmation
        ]);

        // 2. Simpan ke database
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'penumpang', // Default role untuk pendaftar dari HP
        ]);

        // 3. Buat token akses agar setelah daftar bisa langsung login otomatis
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'sukses',
            'pesan'  => 'Registrasi berhasil, selamat bergabung!',
            'user'   => $user,
            'token'  => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        // Menghapus (mencabut) token yang sedang digunakan saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'sukses',
            'pesan'  => 'Berhasil logout. Sampai jumpa kembali!'
        ], 200);
    }
}