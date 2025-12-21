<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">

    <div class="container-fluid">
        <div class="row">

            {{-- SIDEBAR --}}
            <div class="col-md-2 bg-primary text-white min-vh-100 p-4 rounded-end">
                <h5 class="fw-bold mb-4">Arvisual</h5>

                <a href="#" class="d-block text-white text-decoration-none mb-3 fw-semibold">
                    Dashboard
                </a>

                <a href="{{ route('pendapatan') }}" class="d-block text-white text-decoration-none mb-3">
                    Pendapatan
                </a>

                <a href="{{ route('pengeluaran') }}" class="d-block text-white text-decoration-none mb-3">
                    Pengeluaran
                </a>

                <a href="{{ route('akun') }}" class="d-block text-white text-decoration-none mb-3">
                    Akun
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="d-block text-white text-decoration-none mb-3 bg-transparent border-0">
                        Logout
                    </button>
                </form>
            </div>


            <div class="col-md-10 p-4">

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
                                <option value="{{ $y }}"
                                    {{ request('year', now()->year) == $y ? 'selected' : '' }}>
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
                                <h5 class="fw-bold mb-2">
                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </h5>
                                <div class="progress" style="height:5px;">
                                    <div class="progress-bar bg-success w-100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <small class="text-muted">Total Pengeluaran</small>
                                <h5 class="fw-bold mb-2">
                                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                                </h5>
                                <div class="progress" style="height:5px;">
                                    <div class="progress-bar bg-danger w-100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <small class="text-muted">Saldo Bersih</small>
                                <h5 class="fw-bold mb-2">
                                    Rp {{ number_format($saldoBersih, 0, ',', '.') }}
                                </h5>
                                <div class="progress" style="height:5px;">
                                    <div class="progress-bar bg-dark w-100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <small class="text-muted">Total Transaksi</small>
                                <h5 class="fw-bold mb-2">
                                    {{ $totalTransaksi }}
                                </h5>
                                <div class="progress" style="height:5px;">
                                    <div class="progress-bar bg-primary w-100"></div>
                                </div>
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

                    {{-- BUTTON --}}
                    <div class="col-md-4 d-grid gap-2">
                        <a href="{{ route('pendapatan.create') }}" class="btn btn-primary">
                            Tambah Pendapatan
                        </a>
                        <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary">
                            Tambah Pengeluaran
                        </a>
                        <a href="#" class="btn btn-primary">
                            Buat Laporan
                        </a>
                        <a href="#" class="btn btn-primary">
                            Export Data
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

</body>

</html>
