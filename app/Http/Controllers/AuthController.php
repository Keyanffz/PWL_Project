<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\UserToken;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post('https://jwt-auth-eight-neon.vercel.app/login', [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $refreshToken = $data['refreshToken'];

            // Simpan token ke database
            UserToken::updateOrCreate(
                ['email' => $request->email],
                ['refresh_token' => $refreshToken]
            );

            // Simpan ke session
            session(['refresh_token' => $refreshToken, 'email' => $request->email]);

            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function dashboard()
    {
        if (!session('refresh_token')) {
            return redirect()->route('login');
        }
        return view('dashboard');
    }

    public function logout(Request $request)
{
    $token = session('refresh_token');

    if ($token) {
        Http::withToken($token)->get('https://jwt-auth-eight-neon.vercel.app/logout');
    }

    session()->flush();
    return redirect()->route('login')->with('success', 'Berhasil logout!');
}
}