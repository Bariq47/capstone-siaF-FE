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
        $this->forbidIfNotAllowed();

        $year = $request->input('year', Carbon::now()->year);

        // Ambil data tren bulanan
        $response = Http::withToken($this->token())
            ->get(env('API_URL') . "/trenBulanan/$year")
            ->json();

        $dataBulan = $response['data'] ?? [];

        // Hitung total pendapatan/pengeluaran per bulan (opsional)
        $totalPendapatan = collect($dataBulan)->sum('totalPendapatan');
        $totalPengeluaran = collect($dataBulan)->sum('totalPengeluaran');

        return view('dashboard', [
            'year' => $year,
            'dataBulan' => $dataBulan,
            'totalPendapatan' => $totalPendapatan,
            'totalPengeluaran' => $totalPengeluaran
        ]);
    }
}
