<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{

    private function token()
    {
        return session('jwt_token');
    }

    private function role()
    {
        return session('role');
    }

    private function forbidIfNotAllowed()
    {
        if (!in_array($this->role(), ['admin', 'superAdmin'])) {
            abort(403, 'Akses ditolak');
        }
    }
    public function index(Request $request)
    {
        $year  = $request->query('year', now()->year);
        $month = $request->query('month');

        $response = Http::withToken(session('jwt_token'))
            ->get(env('API_URL') . '/summary', [
                'year' => $year,
                'month' => $month,
            ]);

        if (!$response->successful()) {
            abort(500, 'Gagal mengambil data dashboard');
        }

        $data = $response->json();

        return view('dashboard', [
            'totalPendapatan' => $data['totalPendapatan'] ?? 0,
            'totalPengeluaran' => $data['totalPengeluaran'] ?? 0,
            'saldoBersih' => $data['saldoBersih'] ?? 0,
            'totalTransaksi' => $data['totalTransaksi'] ?? 0,
            'year' => $year,
            'month' => $month,
        ]);
    }
}
