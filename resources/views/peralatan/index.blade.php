@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6 flex-wrap gap-4">
    <h1 class="text-2xl font-bold text-primary">Data Peralatan</h1>
    <a href="{{ route('peralatan.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
        <i class="fas fa-plus"></i> Tambah Peralatan
    </a>
</div>

<div class="bg-white rounded-lg shadow p-4 mb-6">
    <!-- Filter tanpa tombol, submit otomatis saat berubah -->
    <form method="GET" action="{{ route('peralatan.index') }}" class="flex flex-wrap gap-4" id="filter-form">
        <input type="text" name="search" placeholder="Cari nama peralatan..." value="{{ request()->get('search') }}" 
            class="flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:border-primary"
            id="search-input">
        
        <select name="kategori" class="px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" id="kategori-select">
            <option value="">Semua Kategori</option>
            @foreach($kategoriList as $kat)
                <option value="{{ $kat }}" {{ request()->get('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
            @endforeach
        </select>
        
        <!-- Tombol reset saja yang manual -->
        <a href="{{ route('peralatan.index') }}" class="bg-darkGray text-white px-4 py-2 rounded-lg hover:bg-mediumGray transition">
            <i class="fas fa-undo"></i> Reset
        </a>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($peralatans as $item)
    <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition border-t-4 border-primary">
        @if($item->foto)
            <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-mediumGray bg-opacity-20 flex items-center justify-center">
                <i class="fas fa-camera text-mediumGray text-4xl"></i>
            </div>
        @endif
        <div class="p-4">
            <h3 class="font-bold text-lg text-primary">{{ $item->nama_peralatan }}</h3>
            <p class="text-darkGray text-sm">Kategori: {{ $item->kategori }}</p>
            <div class="mt-3 flex justify-between items-center">
                <span class="text-primary font-bold">Stok: {{ $item->jumlah_stok }}</span>
                <div class="space-x-2">
                    <a href="{{ route('peralatan.show', $item->id) }}" class="text-primary hover:text-primaryLight">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('peralatan.edit', $item->id) }}" class="text-darkGray hover:text-mediumGray">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('peralatan.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-primary hover:text-primaryLight" onclick="return confirm('Yakin hapus?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-10 bg-white rounded-lg shadow">
        <i class="fas fa-box-open text-5xl text-mediumGray mb-3"></i>
        <p class="text-darkGray">Tidak ada data peralatan</p>
        <a href="{{ route('peralatan.create') }}" class="inline-block mt-3 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
            <i class="fas fa-plus"></i> Tambah Peralatan
        </a>
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $peralatans->appends(request()->query())->links() }}
</div>

<script>
    // Auto submit saat select berubah
    document.getElementById('kategori-select').addEventListener('change', function() {
        document.getElementById('filter-form').submit();
    });
    
    document.getElementById('kondisi-select').addEventListener('change', function() {
        document.getElementById('filter-form').submit();
    });
    
    // Search dengan debounce (delay 500ms agar tidak terlalu sering submit)
    let searchTimeout;
    document.getElementById('search-input').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filter-form').submit();
        }, 500);
    });
</script>
@endsection