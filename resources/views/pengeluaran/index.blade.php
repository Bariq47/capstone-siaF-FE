<h2>Data pengeluaran</h2>

{{-- Tombol Tambah pengeluaran --}}
<a href="{{ route('pengeluaran.create') }}">
    <button type="button">Tambah pengeluaran</button>
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
        @forelse ($pengeluaran as $p)
            <tr>
                <td>{{ $p['tanggal'] }}</td>
                <td>{{ $p['deskripsi'] }}</td>
                <td>{{ $p['nominal'] }}</td>
                <td>
                    <a href="{{ route('pengeluaran.edit', $p['id']) }}">Edit</a>
                    <form action="{{ route('pengeluaran.destroy', $p['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center;">Belum ada data pengeluaran</td>
            </tr>
        @endforelse
    </tbody>
</table>
