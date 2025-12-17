<h2>Data Pendapatan</h2>

{{-- Tombol Tambah Pendapatan --}}
<a href="{{ route('pendapatan.create') }}">
    <button type="button">Tambah Pendapatan</button>
</a>

<table border="1" cellpadding="5" cellspacing="0" style="margin-top:10px;">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Deskripsi</th>
            <th>Nominal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pendapatan as $p)
            <tr>
                <td>{{ $p['tanggal'] }}</td>
                <td>{{ $p['deskripsi'] }}</td>
                <td>{{ $p['nominal'] }}</td>
                <td>
                    <a href="{{ route('pendapatan.edit', $p['id']) }}">Edit</a>
                    <form action="{{ route('pendapatan.destroy', $p['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center;">Belum ada data pendapatan</td>
            </tr>
        @endforelse
    </tbody>
</table>
