@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-primary">Edit Peminjaman</h1>

    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-darkGray mb-2">Pengguna <span class="text-primary">*</span></label>
                <select name="pengguna_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                    <option value="">Pilih Pengguna</option>
                    @foreach($penggunas as $item)
                        <option value="{{ $item->id }}" {{ $peminjaman->pengguna_id == $item->id ? 'selected' : '' }}>
                            {{ $item->nama }} ({{ $item->kelas }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Peralatan <span class="text-primary">*</span></label>
                <select name="peralatan_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                    <option value="">Pilih Peralatan</option>
                    @foreach($peralatans as $item)
                        <option value="{{ $item->id }}" {{ $peminjaman->peralatan_id == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_peralatan }} (Stok: {{ $item->jumlah_stok }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Jumlah Pinjam <span class="text-primary">*</span></label>
                <input type="number" name="jumlah_pinjam" value="{{ $peminjaman->jumlah_pinjam }}" min="1" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Tanggal Pinjam <span class="text-primary">*</span></label>
                <input type="date" name="tanggal_pinjam" value="{{ $peminjaman->tanggal_pinjam }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" value="{{ $peminjaman->tanggal_kembali }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
                <p class="text-xs text-mediumGray mt-1">Kosongkan jika belum dikembalikan</p>
            </div>
        </div>
        <div class="mt-6 flex space-x-2">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('peminjaman.index') }}" class="bg-darkGray text-white px-6 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection