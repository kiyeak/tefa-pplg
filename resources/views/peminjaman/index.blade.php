@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6 flex-wrap gap-4">
    <h1 class="text-2xl font-bold text-primary">Data Peminjaman</h1>
    <div class="flex space-x-2">
        <a href="{{ route('export.excel') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('export.pdf') }}" class="bg-darkGray text-white px-4 py-2 rounded-lg hover:bg-mediumGray transition">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <a href="{{ route('peminjaman.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" action="{{ route('peminjaman.index') }}" class="flex flex-wrap gap-4" id="filter-form">
        <input type="text" name="search" placeholder="Cari pengguna atau peralatan..." value="{{ request('search') }}" 
            class="flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:border-primary"
            id="search-input">
        
        <select name="status" class="px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" id="status-select">
            <option value="">Semua Status</option>
            <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
        </select>
        
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
            <i class="fas fa-search"></i> Filter
        </button>
        
        <a href="{{ route('peminjaman.index') }}" class="bg-darkGray text-white px-4 py-2 rounded-lg hover:bg-mediumGray transition">
            <i class="fas fa-undo"></i> Reset
        </a>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-primary text-white">
            <tr class="text-left">
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Pengguna</th>
                <th class="px-6 py-3">Peralatan</th>
                <th class="px-6 py-3">Jumlah</th>
                <th class="px-6 py-3">Tgl Pinjam</th>
                <th class="px-6 py-3">Tgl Kembali</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($peminjamans as $item)
            <tr>
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">{{ $item->pengguna->nama }}<br><small class="text-mediumGray">{{ $item->pengguna->kelas }}</small></td>
                <td class="px-6 py-4">{{ $item->peralatan->nama_peralatan }}</td>
                <td class="px-6 py-4">{{ $item->jumlah_pinjam }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                <td class="px-6 py-4">{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                <td class="px-6 py-4">
                    @if($item->status == 'Dipinjam')
                        <span class="bg-primaryLight text-white px-2 py-1 rounded text-sm">Dipinjam</span>
                    @else
                        <span class="bg-mediumGray text-white px-2 py-1 rounded text-sm">Dikembalikan</span>
                    @endif
                </td>
                <td class="px-6 py-4 space-x-2">
                    <!-- Tombol Lihat (selalu ada) -->
                    <a href="{{ route('peminjaman.show', $item->id) }}" class="text-primary hover:text-primaryLight">
                        <i class="fas fa-eye"></i>
                    </a>
                    
                    <!-- Tombol Kembalikan (hanya jika status Dipinjam) -->
                    @if($item->status == 'Dipinjam')
                    <form action="{{ route('peminjaman.kembali', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-darkGray hover:text-mediumGray" onclick="return confirm('Kembalikan barang? Stok akan bertambah.')">
                            <i class="fas fa-undo"></i>
                        </button>
                    </form>
                    @endif
                    
                    <!-- Aksi untuk ADMIN -->
                    @if(auth()->user()->isAdmin())
                        @if($item->status == 'Dipinjam')
                            <!-- Status DIPINJAM → hanya EDIT, TIDAK BOLEH HAPUS -->
                            <a href="{{ route('peminjaman.edit', $item->id) }}" class="text-darkGray hover:text-mediumGray">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- HAPUS tidak muncul untuk status Dipinjam -->
                        @else
                            <!-- Status DIKEMBALIKAN → hanya HAPUS, TIDAK BOLEH EDIT -->
                            <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-primary hover:text-primaryLight" onclick="return confirm('Yakin hapus data peminjaman ini? Data akan hilang permanen.')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <!-- EDIT tidak muncul untuk status Dikembalikan -->
                        @endif
                    @endif
                    
                    <!-- Pesan untuk user biasa (bukan admin) -->
                    @if(!auth()->user()->isAdmin() && $item->status == 'Dikembalikan')
                        <span class="text-xs text-mediumGray italic">(riwayat)</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-8 text-center text-mediumGray">
                    <i class="fas fa-inbox text-4xl mb-2 block"></i>
                    Tidak ada data peminjaman
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $peminjamans->appends(request()->query())->links() }}
</div>

<script>
    $(document).ready(function() {
        // Auto submit saat select status berubah
        $('#status-select').on('change', function() {
            $('#filter-form').submit();
        });
        
        // Search dengan debounce 500ms
        let timer;
        $('#search-input').on('keyup', function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                $('#filter-form').submit();
            }, 500);
        });
    });
</script>
@endsection