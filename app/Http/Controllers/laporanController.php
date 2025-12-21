<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class laporanController extends Controller
{
    private function token()
    {
        return session('jwt_token');
    }

    public function index(Request $request)
    {

        $year = $request->input('year', Carbon::now()->year);

        $response = Http::withToken($this->token())
            ->get(env('API_URL') . "/trenBulanan/$year")
            ->json();

        // dd($response);

        $dataBulan = $response['data'] ?? [];
        // dd($dataBulan);

        $totalPendapatan = collect($dataBulan)->sum('totalPendapatan');
        $totalPengeluaran = collect($dataBulan)->sum('totalPengeluaran');
        $saldoBersih = $totalPendapatan - $totalPengeluaran;

        // dd($totalPendapatan, $totalPengeluaran, $saldoBersih);

        return view('laporan.index', [
            'year' => $year,
            'dataBulan' => $dataBulan,
            'totalPendapatan' => $totalPendapatan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoBersih' => $saldoBersih,
        ]);
    }
}
