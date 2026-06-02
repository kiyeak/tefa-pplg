@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-primary">Detail Peminjaman</h1>
        <div class="space-x-2">
            @if($peminjaman->status == 'Dipinjam' && auth()->user()->isAdmin())
            <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-edit"></i> Edit
            </a>
            @endif
            <a href="{{ route('peminjaman.index') }}" class="bg-darkGray text-white px-4 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border rounded-lg p-4">
            <h3 class="font-semibold text-primary mb-3">Informasi Pengguna</h3>
            <table class="w-full text-sm">
                <tr><td class="py-1 text-mediumGray">Nama</td><td class="py-1">: {{ $peminjaman->pengguna->nama }}</td></tr>
                <tr><td class="py-1 text-mediumGray">Email</td><td class="py-1">: {{ $peminjaman->pengguna->email }}</td></tr>
                <tr><td class="py-1 text-mediumGray">Kelas</td><td class="py-1">: {{ $peminjaman->pengguna->kelas }}</td></tr>
                <tr><td class="py-1 text-mediumGray">Jurusan</td><td class="py-1">: {{ $peminjaman->pengguna->jurusan }}</td></tr>
                <tr><td class="py-1 text-mediumGray">No HP</td><td class="py-1">: {{ $peminjaman->pengguna->no_hp }}</td></tr>
            </table>
        </div>
        <div class="border rounded-lg p-4">
            <h3 class="font-semibold text-primary mb-3">Informasi Peralatan</h3>
            <table class="w-full text-sm">
                <tr><td class="py-1 text-mediumGray">Nama Peralatan</td><td class="py-1">: {{ $peminjaman->peralatan->nama_peralatan }}</td></tr>
                <tr><td class="py-1 text-mediumGray">Kategori</td><td class="py-1">: {{ $peminjaman->peralatan->kategori }}</td></tr>
                <tr><td class="py-1 text-mediumGray">Kondisi</td><td class="py-1">: {{ ucfirst($peminjaman->peralatan->kondisi) }}</td></tr>
            </table>
        </div>
        <div class="border rounded-lg p-4">
            <h3 class="font-semibold text-primary mb-3">Informasi Peminjaman</h3>
            <table class="w-full text-sm">
                <tr><td class="py-1 text-mediumGray">Jumlah Pinjam</td><td class="py-1">: {{ $peminjaman->jumlah_pinjam }} item</td></tr>
                <tr><td class="py-1 text-mediumGray">Tanggal Pinjam</td><td class="py-1">: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</td></tr>
                <tr><td class="py-1 text-mediumGray">Tanggal Kembali</td><td class="py-1">: {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') : '-' }}</td></tr>
                <tr><td class="py-1 text-mediumGray">Status</td>
                    <td class="py-1">: 
                        @if($peminjaman->status == 'Dipinjam')
                            <span class="bg-primaryLight text-white px-2 py-1 rounded text-sm">Dipinjam</span>
                        @else
                            <span class="bg-mediumGray text-white px-2 py-1 rounded text-sm">Dikembalikan</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- Tombol Kembalikan jika status Dipinjam -->
    @if($peminjaman->status == 'Dipinjam')
    <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
        <div class="flex justify-between items-center">
            <div>
                <i class="fas fa-info-circle text-yellow-600"></i>
                <span class="text-yellow-700">Barang sedang dipinjam</span>
            </div>
            <form action="{{ route('peminjaman.kembali', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition" onclick="return confirm('Kembalikan barang ini? Stok akan bertambah.')">
                    <i class="fas fa-undo"></i> Kembalikan Sekarang
                </button>
            </form>
        </div>
    </div>
    @else
    <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 mr-2"></i>
            <span class="text-green-700">Barang sudah dikembalikan pada {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y H:i:s') }}</span>
        </div>
    </div>
    @endif
</div>
@endsection