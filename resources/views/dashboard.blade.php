<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Informasi Akuntansi</title>
</head>

<body>
    <nav style="margin-bottom:20px;">
        <a href="#">Dashboard</a> <br>
        <a href="{{ route('pendapatan') }}">Pendapatan</a><br>
        <a href="{{ route('pengeluaran') }}">Pengeluaran</a><br>
        <a href="#">Laporan</a><br>
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
