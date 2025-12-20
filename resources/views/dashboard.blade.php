<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .card {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
    <title>Sistem Informasi Akuntansi</title>
</head>

<body>
    <h2>Dashboard Tahun {{ $year }}</h2>

    <div class="card">
        <h5>Line Chart Pendapatan & Pengeluaran Bulanan</h5>
        <canvas id="lineChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('lineChart').getContext('2d');

        const labels = {!! json_encode(
            array_map(function ($d) {
                return 'Bulan ' . $d['bulan'];
            }, $dataBulan),
        ) !!};
        const dataPendapatan = {!! json_encode(array_column($dataBulan, 'totalPendapatan')) !!};
        const dataPengeluaran = {!! json_encode(array_column($dataBulan, 'totalPengeluaran')) !!};

        const lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Pendapatan',
                        data: dataPendapatan,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.4
                    },
                    {
                        label: 'Pengeluaran',
                        data: dataPengeluaran,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <nav style="margin-bottom:20px;">
        <a href="#">Dashboard</a> <br>
        <a href="{{ route('pendapatan') }}">Pendapatan</a><br>
        <a href="{{ route('pengeluaran') }}">Pengeluaran</a><br>
        <a href="{{ route('laporan') }}">Laporan</a><br>
        <a href="{{ route('akun') }}">Akun</a>

        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    <hr>

    @yield('content')
</body>

</html>
