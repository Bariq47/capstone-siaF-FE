<h2>Manajemen Akun</h2>

{{-- Tombol tambah hanya untuk SuperAdmin --}}
@if ($role === 'superAdmin')
    <a href="/akun/tambah">Tambah Akun</a>
@endif

<table border="1">
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>

    @foreach ($users as $user)
        <tr>
            <td>{{ $user['username'] }}</td>
            <td>{{ $user['email'] }}</td>
            <td>{{ $user['role'] }}</td>
            <td>
                @if ($role === 'superAdmin')
                    <a href="/akun/{{ $user['id'] }}/edit">Edit</a>

                    <form action="/akun/{{ $user['id'] }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                @else
                    -
                @endif
            </td>
        </tr>
    @endforeach
</table>
