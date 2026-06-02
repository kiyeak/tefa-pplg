@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-primary">Edit Pengguna</h1>

    <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-darkGray mb-2">Nama Lengkap <span class="text-primary">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $pengguna->nama) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Email <span class="text-primary">*</span></label>
                <input type="email" name="email" value="{{ old('email', $pengguna->email) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
                <p class="text-xs text-mediumGray mt-1">Kosongkan jika tidak ingin mengubah password</p>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Kelas <span class="text-primary">*</span></label>
                <input type="text" name="kelas" value="{{ old('kelas', $pengguna->kelas) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Jurusan <span class="text-primary">*</span></label>
                <input type="text" name="jurusan" value="{{ old('jurusan', $pengguna->jurusan) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">No HP <span class="text-primary">*</span></label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $pengguna->no_hp) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Role <span class="text-primary">*</span></label>
                <select name="role" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                    <option value="user" {{ old('role', $pengguna->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $pengguna->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>
        <div class="mt-6 flex space-x-2">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('pengguna.index') }}" class="bg-darkGray text-white px-6 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection