<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class userViewController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post('http://localhost:8000/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->withErrors([
                'email' => 'Email atau password salah',
            ]);
        }

        session([
            'jwt_token' => $response->json('token'),
            'role'=> $response->json('user.role'),
        ]);

        return redirect('/dashboard');
    }

    public function logout()
    {
        session()->forget('jwt_token');
        return redirect('/login');
    }
}
