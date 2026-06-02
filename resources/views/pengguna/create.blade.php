@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-primary">Tambah Pengguna</h1>

    <form action="{{ route('pengguna.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-darkGray mb-2">Nama Lengkap <span class="text-primary">*</span></label>
                <input type="text" name="nama" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Email <span class="text-primary">*</span></label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Password <span class="text-primary">*</span></label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                <p class="text-xs text-mediumGray mt-1">Minimal 6 karakter</p>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Kelas <span class="text-primary">*</span></label>
                <input type="text" name="kelas" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Jurusan <span class="text-primary">*</span></label>
                <input type="text" name="jurusan" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">No HP <span class="text-primary">*</span></label>
                <input type="text" name="no_hp" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Role <span class="text-primary">*</span></label>
                <select name="role" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
        <div class="mt-6 flex space-x-2">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('pengguna.index') }}" class="bg-darkGray text-white px-6 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection