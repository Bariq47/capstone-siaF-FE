<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pendapatan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">

    <div class="container-fluid px-4 py-3">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Pendapatan</h4>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span class="text-muted">Total Pendapatan Bulan Ini</span>
                </div>
                <div class="fw-bold text-success fs-5">
                    {{-- RP. {{ number_format($totalPendapatan, 0, ',', '.') }} --}}
                </div>
            </div>

            <a href="{{ route('pendapatan.create') }}" class="btn btn-primary px-4">
                <i class="bi bi-plus-lg me-1"></i> Tambah Pendapatan
            </a>
        </div>

        {{-- Search & Export --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group w-50">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Cari Transaksi">
            </div>

            <a href="#" class="btn btn-outline-dark">
                <i class="bi bi-download me-1"></i> Export
            </a>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="fw-semibold">Tanggal</th>
                            <th class="fw-semibold">Deskripsi</th>
                            <th class="fw-semibold">Nominal</th>
                            <th class="fw-semibold text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pendapatan as $p)
                            <tr>
                                <td>{{ $p['tanggal'] }}</td>
                                <td>{{ $p['deskripsi'] }}</td>
                                <td class="text-success fw-semibold">
                                    Rp {{ number_format($p['nominal'], 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('pendapatan.edit', $p['id']) }}" class="btn btn-warning">
                                            Edit
                                        </a>
                                        <form action="{{ route('pendapatan.destroy', $p['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Yakin ingin hapus?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data pendapatan.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>

</body>

</html>
