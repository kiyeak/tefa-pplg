@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-primary">Tambah Peralatan</h1>

    <form action="{{ route('peralatan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-darkGray mb-2">Nama Peralatan <span class="text-primary">*</span></label>
                <input type="text" name="nama_peralatan" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Kategori <span class="text-primary">*</span></label>
                <select name="kategori" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}">{{ $kat }}</option>
                    @endforeach
                </select>
                @if($kategoriList->isEmpty())
                    <p class="text-xs text-primary mt-1">Belum ada kategori. Silakan tambah kategori di form ini.</p>
                    <input type="text" name="kategori" placeholder="Masukkan kategori baru" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary mt-2">
                @endif
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Jumlah Stok <span class="text-primary">*</span></label>
                <input type="number" name="jumlah_stok" min="0" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-darkGray mb-2">Foto</label>
                <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
                <p class="text-xs text-mediumGray mt-1">Format: JPG, JPEG, PNG. Maks: 2MB</p>
            </div>
        </div>
        <div class="mt-6 flex space-x-2">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('peralatan.index') }}" class="bg-darkGray text-white px-6 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection