@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-primary">Detail Peralatan</h1>
        <div class="space-x-2">
            <a href="{{ route('peralatan.edit', $peralatan->id) }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('peralatan.index') }}" class="bg-darkGray text-white px-4 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Bagian Foto -->
        <div class="border rounded-lg p-4">
            <h3 class="font-semibold text-primary mb-3">Foto Peralatan</h3>
            <div class="flex justify-center">
                @if($peralatan->foto)
                    <img src="{{ asset('storage/' . $peralatan->foto) }}" 
                         class="w-full max-w-md rounded-lg shadow" 
                         alt="{{ $peralatan->nama_peralatan }}">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-camera text-gray-400 text-6xl"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bagian Informasi Peralatan -->
        <div class="border rounded-lg p-4">
            <h3 class="font-semibold text-primary mb-3">Informasi Peralatan</h3>
            <table class="w-full">
                <tr>
                    <td class="py-2 text-darkGray w-32">Nama Peralatan</td>
                    <td class="py-2">: <span class="font-semibold">{{ $peralatan->nama_peralatan }}</span></td>
                </tr>
                <tr>
                    <td class="py-2 text-darkGray">Kategori</td>
                    <td class="py-2">: <span class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $peralatan->kategori }}</span></td>
                </tr>
                <tr>
                    <td class="py-2 text-darkGray">Jumlah Stok</td>
                    <td class="py-2">: 
                        <span class="font-bold text-primary">{{ $peralatan->jumlah_stok }}</span> 
                        <span class="text-sm text-mediumGray">unit</span>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 text-darkGray">Kondisi</td>
                    <td class="py-2">: 
                        @if($peralatan->kondisi == 'baik')
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Baik</span>
                        @elseif($peralatan->kondisi == 'rusak')
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Rusak</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Perbaikan</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="py-2 text-darkGray">Dibuat pada</td>
                    <td class="py-2">: {{ $peralatan->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-darkGray">Terakhir diupdate</td>
                    <td class="py-2">: {{ $peralatan->updated_at->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>

            <!-- Status Stok -->
            <div class="mt-4 pt-3 border-t">
                <div class="flex items-center space-x-2">
                    <span class="text-darkGray">Status Stok:</span>
                    @if($peralatan->jumlah_stok <= 0)
                        <span class="bg-red-500 text-white px-2 py-1 rounded text-sm">Habis</span>
                    @elseif($peralatan->jumlah_stok <= 3)
                        <span class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Hampir Habis</span>
                    @else
                        <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Tersedia</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Peminjaman Peralatan -->
    <div class="border rounded-lg p-4 mt-6">
        <h3 class="font-semibold text-primary mb-3">
            <i class="fas fa-history mr-2"></i> Riwayat Peminjaman
        </h3>
        
        @if($peralatan->peminjamans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Peminjam</th>
                            <th class="px-4 py-2 text-left">Tanggal Pinjam</th>
                            <th class="px-4 py-2 text-left">Tanggal Kembali</th>
                            <th class="px-4 py-2 text-left">Jumlah</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peralatan->peminjamans as $index => $pinjam)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $pinjam->pengguna->nama }}<br><small class="text-xs text-mediumGray">{{ $pinjam->pengguna->kelas }}</small></td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $pinjam->tanggal_kembali ? \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-2">{{ $pinjam->jumlah_pinjam }}</td>
                            <td class="px-4 py-2">
                                @if($pinjam->status == 'Dipinjam')
                                    <span class="bg-primaryLight text-white px-2 py-1 rounded text-xs">Dipinjam</span>
                                @else
                                    <span class="bg-mediumGray text-white px-2 py-1 rounded text-xs">Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-right text-sm text-mediumGray">
                Total peminjaman: {{ $peralatan->peminjamans->count() }} kali
            </div>
        @else
            <div class="text-center py-8 text-mediumGray">
                <i class="fas fa-inbox text-4xl mb-2 block"></i>
                Belum ada riwayat peminjaman untuk peralatan ini
            </div>
        @endif
    </div>
</div>
@endsection