<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Pendapatan</title>
</head>

<body>

    <h2>Edit Pendapatan</h2>

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

    <form method="POST" action="/pendapatan/{{ $pendapatan['id'] }}">
        @csrf
        @method('PUT')

        <label>Tanggal</label><br>
        <input type="date" name="tanggal" value="{{ old('tanggal', $pendapatan['tanggal']) }}" required>
        <br><br>

        <label>Deskripsi</label><br>
        <input type="text" name="deskripsi" value="{{ old('deskripsi', $pendapatan['deskripsi']) }}" required>
        <br><br>

        <label>Nominal</label><br>
        <input type="number" name="nominal" value="{{ old('nominal', $pendapatan['nominal']) }}" required>
        <br><br>

        <button type="submit">Update</button>
        <a href="/pendapatan">Kembali</a>
    </form>

</body>

</html>
