@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-primary">Detail Pengguna</h1>
        <a href="{{ route('pengguna.index') }}" class="bg-darkGray text-white px-4 py-2 rounded-lg hover:bg-mediumGray transition">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border rounded-lg p-4">
            <table class="w-full">
                <tr>
                    <td class="py-2 text-mediumGray w-32">Nama Lengkap</td>
                    <td class="py-2">: {{ $pengguna->nama }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-mediumGray">Kelas</td>
                    <td class="py-2">: {{ $pengguna->kelas }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-mediumGray">Jurusan</td>
                    <td class="py-2">: {{ $pengguna->jurusan }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-mediumGray">No HP</td>
                    <td class="py-2">: {{ $pengguna->no_hp }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-mediumGray">Dibuat pada</td>
                    <td class="py-2">: {{ $pengguna->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="border rounded-lg p-4">
            <h3 class="font-semibold text-primary mb-3">Riwayat Peminjaman</h3>
            <div class="max-h-60 overflow-y-auto">
                @forelse($pengguna->peminjamans as $pinjam)
                    <div class="border-b py-2 text-sm">
                        <div class="font-semibold">{{ $pinjam->peralatan->nama_peralatan }}</div>
                        <div class="text-mediumGray">Pinjam: {{ $pinjam->tanggal_pinjam }}</div>
                        <div class="text-mediumGray">Status: {{ $pinjam->status }}</div>
                    </div>
                @empty
                    <p class="text-mediumGray">Belum ada riwayat peminjaman</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection