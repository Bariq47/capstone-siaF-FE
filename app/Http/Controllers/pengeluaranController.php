<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class pengeluaranController extends Controller
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
        // Contoh: hanya admin atau superAdmin boleh mengelola pengeluaran
        if (!in_array($this->role(), ['admin', 'superAdmin'])) {
            abort(403, 'Akses ditolak');
        }
    }
    private function getKategoripengeluaran()
    {
        $kategori = Http::withToken($this->token())
            ->get(env('API_URL') . '/kategori')
            ->json();

        $kategoripengeluaran = collect($kategori)
            ->firstWhere('jenis', 'pengeluaran');

        return $kategoripengeluaran['id'] ?? null;
    }
    public function index()
    {
        $pengeluaran = Http::withToken($this->token())
            ->get(env('API_URL') . '/laporanPengeluaran')
            ->json('data');

        return view('pengeluaran.index', [
            'pengeluaran' => $pengeluaran,
            'role'  => $this->role()
        ]);
    }

    public function create()
    {
        $this->forbidIfNotAllowed();

        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $this->forbidIfNotAllowed();

        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'nominal' => 'required|numeric',
        ]);
        $kategoriId = $this->getKategoripengeluaran();
        if (!$kategoriId) {
            return back()->withErrors(['error' => 'Kategori pengeluaran belum tersedia']);
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
                ->withErrors($response->json('errors') ?? ['error' => 'Gagal menambah pengeluaran'])
                ->withInput();
        }

        return redirect('/pengeluaran')->with('success', 'pengeluaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->forbidIfNotAllowed();

        $pengeluaran = Http::withToken($this->token())
            ->get(env('API_URL') . "/transaksi/$id")
            ->json('data');

        if (!$pengeluaran) {
            return redirect('/pengeluaran')
                ->withErrors(['error' => 'pengeluaran tidak ditemukan']);
        }
        $pengeluaran['tanggal'] = Carbon::parse($pengeluaran['tanggal'])->format('Y-m-d');

        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, $id)
    {
        $this->forbidIfNotAllowed();

        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'nominal' => 'required|numeric',
        ]);

        $kategoriId = $this->getKategoripengeluaran();
        if (!$kategoriId) {
            return back()->withErrors(['error' => 'Kategori pengeluaran belum tersedia']);
        }

        if (!$kategoriId) {
            return back()->withErrors(['error' => 'Kategori pengeluaran belum tersedia']);
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
                ->withErrors($response->json('errors') ?? ['error' => 'Gagal update pengeluaran'])
                ->withInput();
        }

        return redirect('/pengeluaran')->with('success', 'pengeluaran berhasil diupdate');
    }

    public function destroy($id)
    {
        $this->forbidIfNotAllowed();

        $response = Http::withToken($this->token())
            ->delete(env('API_URL') . "/transaksi/$id");

        if ($response->failed()) {
            return redirect('/pengeluaran')
                ->withErrors(['error' => 'Gagal menghapus pengeluaran']);
        }

        return redirect('/pengeluaran')->with('success', 'pengeluaran berhasil dihapus');
    }
}
