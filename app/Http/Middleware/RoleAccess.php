<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAccess
{
    private function token()
    {
        return session('jwt_token');
    }

    private function role()
    {
        return session('role');
    }

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$this->token()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        if (!in_array($this->role(), $roles)) {
            session()->flush();

            return redirect()->route('login')
                ->with('error', 'Akses ditolak');
        }

        return $next($request);
    }
}
