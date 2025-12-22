@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- FILTER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Dashboard</h4>

        <form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2">

            <select name="month" class="form-select form-select-sm">
                <option value="">Semua Bulan</option>
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <select name="year" class="form-select form-select-sm">
                @for ($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>

            <button class="btn btn-primary btn-sm">Terapkan</button>
        </form>
    </div>

    {{-- CARD STATISTIK --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Total Pendapatan</small>
                    <h5 class="fw-bold">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Total Pengeluaran</small>
                    <h5 class="fw-bold">
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Saldo Bersih</small>
                    <h5 class="fw-bold">
                        Rp {{ number_format($saldoBersih, 0, ',', '.') }}
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Total Transaksi</small>
                    <h5 class="fw-bold">
                        {{ $totalTransaksi }}
                    </h5>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3">

        {{-- CHART --}}
        <div class="col-md-8">
            <div class="card shadow-sm" style="height:300px;">
                <div class="card-body">
                    <strong>Tren Transaksi</strong>
                    <div class="text-muted mt-3">
                        CHART
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTION --}}
        <div class="col-md-4 d-grid gap-2">
            <a href="{{ route('pendapatan.create') }}" class="btn btn-primary">
                Tambah Pendapatan
            </a>
            <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary">
                Tambah Pengeluaran
            </a>
            <a href="#" class="btn btn-outline-primary">
                Buat Laporan
            </a>
            <a href="#" class="btn btn-outline-dark">
                Export Data
            </a>
        </div>

    </div>

@endsection
