<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AkunController extends Controller
{
    private function token()
    {
        return session('jwt_token');
    }

    private function role()
    {
        return session('role');
    }

    private function forbidIfNotSuperAdmin()
    {
        if ($this->role() !== 'superAdmin') {
            abort(403, 'Akses ditolak');
        }
    }

    public function index()
    {
        $users = Http::withToken($this->token())
            ->get(env('API_URL') . '/users')
            ->json('users');

        return view('akun.index', [
            'users' => $users,
            'role'  => $this->role()
        ]);
    }

    public function create()
    {
        $this->forbidIfNotSuperAdmin();
        return view('akun.create');
    }

    public function store(Request $request)
    {
        $this->forbidIfNotSuperAdmin();

        $response = Http::withToken($this->token())
            ->post(env('API_URL') . '/users', $request->all());

        if ($response->failed()) {
            return back()
                ->withErrors($response->json('errors') ?? ['error' => 'Gagal menambah akun'])
                ->withInput();
        }

        return redirect('/akun');
    }


    public function edit($id)
    {
        $this->forbidIfNotSuperAdmin();

        $user = Http::withToken($this->token())
            ->get(env('API_URL') . "/users/$id")
            ->json('user');

        return view('akun.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->forbidIfNotSuperAdmin();

        $response = Http::withToken($this->token())
            ->put(env('API_URL') . "/users/$id", $request->all());

        if ($response->failed()) {
            return back()
                ->withErrors($response->json('errors') ?? ['error' => 'Gagal update akun'])
                ->withInput();
        }

        return redirect('/akun');
    }


    public function destroy($id)
    {
        $this->forbidIfNotSuperAdmin();

        Http::withToken($this->token())
            ->delete(env('API_URL') . "/users/$id");

        return redirect('/akun');
    }
}
