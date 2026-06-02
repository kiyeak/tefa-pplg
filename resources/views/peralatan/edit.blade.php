@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-primary">Edit Peralatan</h1>

    <form action="{{ route('peralatan.update', $peralatan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-darkGray mb-2">Nama Peralatan <span class="text-primary">*</span></label>
                <input type="text" name="nama_peralatan" value="{{ old('nama_peralatan', $peralatan->nama_peralatan) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Kategori <span class="text-primary">*</span></label>
                <select name="kategori" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}" {{ $peralatan->kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Jumlah Stok <span class="text-primary">*</span></label>
                <input type="number" name="jumlah_stok" min="0" value="{{ old('jumlah_stok', $peralatan->jumlah_stok) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            
            <div class="md:col-span-2">
                @if($peralatan->foto)
                    <div class="mb-3">
                        <p class="text-sm text-mediumGray mb-2">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $peralatan->foto) }}" class="w-32 h-32 object-cover rounded-lg border border-primary border-opacity-30">
                    </div>
                @endif
                <label class="block text-darkGray mb-2">Ganti Foto</label>
                <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
                <p class="text-xs text-mediumGray mt-1">Format: JPG, JPEG, PNG. Maks: 2MB</p>
            </div>
        </div>
        <div class="mt-6 flex space-x-2">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('peralatan.index') }}" class="bg-darkGray text-white px-6 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection