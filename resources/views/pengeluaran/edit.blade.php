<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit pengeluaran</title>
</head>

<body>

    <h2>Edit pengeluaran</h2>

    {{-- Tampilkan error dari backend --}}
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/pengeluaran/{{ $pengeluaran['id'] }}">
        @csrf
        @method('PUT')

        <label>Tanggal</label><br>
        <input type="date" name="tanggal" value="{{ old('tanggal', $pengeluaran['tanggal']) }}" required>
        <br><br>

        <label>Deskripsi</label><br>
        <input type="text" name="deskripsi" value="{{ old('deskripsi', $pengeluaran['deskripsi']) }}" required>
        <br><br>

        <label>Nominal</label><br>
        <input type="number" name="nominal" value="{{ old('nominal', $pengeluaran['nominal']) }}" required>
        <br><br>

        <button type="submit">Update</button>
        <a href="/pengeluaran">Kembali</a>
    </form>

</body>

</html>
