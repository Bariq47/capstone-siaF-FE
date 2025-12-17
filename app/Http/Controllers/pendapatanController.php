<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class pendapatanController extends Controller
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
        // Contoh: hanya admin atau superAdmin boleh mengelola pendapatan
        if (!in_array($this->role(), ['admin', 'superAdmin'])) {
            abort(403, 'Akses ditolak');
        }
    }
    private function getKategoriPendapatan()
    {
        $kategori = Http::withToken($this->token())
            ->get(env('API_URL') . '/kategori')
            ->json();

        $kategoriPendapatan = collect($kategori)
            ->firstWhere('jenis', 'pendapatan');

        return $kategoriPendapatan['id'] ?? null;
    }

    public function index()
    {
        $pendapatan = Http::withToken($this->token())
            ->get(env('API_URL') . '/laporanPendapatan')
            ->json('data');

        return view('pendapatan.index', [
            'pendapatan' => $pendapatan,
            'role'  => $this->role()
        ]);
    }

    public function create()
    {
        $this->forbidIfNotAllowed();

        return view('pendapatan.create');
    }

    public function store(Request $request)
    {
        $this->forbidIfNotAllowed();

        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'nominal' => 'required|numeric',
        ]);
        $kategoriId = $this->getKategoriPendapatan();
        if (!$kategoriId) {
            return back()->withErrors(['error' => 'Kategori pendapatan belum tersedia']);
        }
        $response = Http::withToken($this->token())
            ->post(env('API_URL') . '/transaksi', [
                'tanggal' => $request->tanggal,
                'deskripsi' => $request->deskripsi,
                'nominal' => $request->nominal,
                'kategori_id' => $kategoriId,
            ]);

        if ($response->failed()) {
            return back()
                ->withErrors($response->json('errors') ?? ['error' => 'Gagal menambah pendapatan'])
                ->withInput();
        }

        return redirect('/pendapatan')->with('success', 'Pendapatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->forbidIfNotAllowed();

        $pendapatan = Http::withToken($this->token())
            ->get(env('API_URL') . "/transaksi/$id")
            ->json('data');

        if (!$pendapatan) {
            return redirect('/pendapatan')
                ->withErrors(['error' => 'Pendapatan tidak ditemukan']);
        }
        $pendapatan['tanggal'] = Carbon::parse($pendapatan['tanggal'])->format('Y-m-d');

        return view('pendapatan.edit', compact('pendapatan'));
    }

    public function update(Request $request, $id)
    {
        $this->forbidIfNotAllowed();

        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'nominal' => 'required|numeric',
        ]);

        $kategoriId = $this->getKategoriPendapatan();
        if (!$kategoriId) {
            return back()->withErrors(['error' => 'Kategori pendapatan belum tersedia']);
        }

        if (!$kategoriId) {
            return back()->withErrors(['error' => 'Kategori pendapatan belum tersedia']);
        }
        $response = Http::withToken($this->token())
            ->put(env('API_URL') . "/transaksi/$id", [ // pakai PUT
                'tanggal' => $request->tanggal,
                'deskripsi' => $request->deskripsi,
                'nominal' => $request->nominal,
                'kategori_id' => $kategoriId,
            ]);

        if ($response->failed()) {
            return back()
                ->withErrors($response->json('errors') ?? ['error' => 'Gagal update pendapatan'])
                ->withInput();
        }

        return redirect('/pendapatan')->with('success', 'Pendapatan berhasil diupdate');
    }

    public function destroy($id)
    {
        $this->forbidIfNotAllowed();

        $response = Http::withToken($this->token())
            ->delete(env('API_URL') . "/transaksi/$id");

        if ($response->failed()) {
            return redirect('/pendapatan')
                ->withErrors(['error' => 'Gagal menghapus pendapatan']);
        }

        return redirect('/pendapatan')->with('success', 'Pendapatan berhasil dihapus');
    }
}
