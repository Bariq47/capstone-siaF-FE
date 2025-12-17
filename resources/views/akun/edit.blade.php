<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Akun</title>
</head>

<body>

    <h2>Edit Akun</h2>

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

    <form method="POST" action="/akun/{{ $user['id'] }}">
        @csrf
        @method('PUT')

        <label>Username</label><br>
        <input type="text" name="username" value="{{ old('username', $user['username']) }}" required>
        <br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email', $user['email']) }}" required>
        <br><br>

        <label>Password (kosongkan jika tidak diubah)</label><br>
        <input type="password" name="password">
        <br><br>

        <label>Role</label><br>
        <select name="role">
            <option value="">-- Pilih Role --</option>
            <option value="admin" {{ old('role', $user['role']) === 'admin' ? 'selected' : '' }}>
                Admin
            </option>
            <option value="superAdmin" {{ old('role', $user['role']) === 'superAdmin' ? 'selected' : '' }}>
                Super Admin
            </option>
        </select>
        <br><br>

        <button type="submit">Update</button>
        <a href="/akun">Kembali</a>
    </form>

</body>

</html>
