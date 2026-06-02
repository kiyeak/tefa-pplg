@extends('layouts.app')

@section('content')
<!-- Box Statistik (di atas tabel) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-primary hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mediumGray text-sm mb-1">Total Pengguna</p>
                <p class="text-3xl font-bold text-primary">{{ $totalPengguna }}</p>
                <p class="text-xs text-mediumGray mt-2">
                    <i class="fas fa-user-plus"></i> +{{ rand(2, 8) }} bulan ini
                </p>
            </div>
            <div class="p-4 bg-primaryLight rounded-full bg-opacity-20">
                <i class="fas fa-users text-primary text-3xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-primaryLight hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mediumGray text-sm mb-1">Total Peralatan</p>
                <p class="text-3xl font-bold text-primaryLight">{{ $totalPeralatan }}</p>
                <p class="text-xs text-mediumGray mt-2">
                    <i class="fas fa-boxes"></i> {{ rand(1, 5) }} kategori
                </p>
            </div>
            <div class="p-4 bg-primaryLight rounded-full bg-opacity-20">
                <i class="fas fa-tools text-primaryLight text-3xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-darkGray hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mediumGray text-sm mb-1">Total Peminjaman</p>
                <p class="text-3xl font-bold text-darkGray">{{ $totalPeminjaman }}</p>
                <p class="text-xs text-mediumGray mt-2">
                    <i class="fas fa-chart-line"></i> {{ $sedangDipinjam }} sedang dipinjam
                </p>
            </div>
            <div class="p-4 bg-darkGray rounded-full bg-opacity-20">
                <i class="fas fa-hand-holding text-darkGray text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Peminjaman Terbaru -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="p-6 border-b border-mediumGray">
        <h3 class="text-lg font-semibold text-primary">
            <i class="fas fa-clock mr-2"></i> Peminjaman Terbaru
        </h3>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-mediumGray bg-gray-50">
                        <th class="px-4 py-3 text-darkGray">No</th>
                        <th class="px-4 py-3 text-darkGray">Pengguna</th>
                        <th class="px-4 py-3 text-darkGray">Peralatan</th>
                        <th class="px-4 py-3 text-darkGray">Jumlah</th>
                        <th class="px-4 py-3 text-darkGray">Tanggal Pinjam</th>
                        <th class="px-4 py-3 text-darkGray">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPeminjamans as $index => $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-darkGray">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">
                            <span class="font-medium text-darkGray">{{ $item->pengguna->nama }}</span>
                            <br><small class="text-xs text-mediumGray">{{ $item->pengguna->kelas }}</small>
                        </td>
                        <td class="px-4 py-3 text-darkGray">{{ $item->peralatan->nama_peralatan }}</td>
                        <td class="px-4 py-3 text-darkGray">{{ $item->jumlah_pinjam }}</td>
                        <td class="px-4 py-3 text-darkGray">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            @if($item->status == 'Dipinjam')
                                <span class="bg-primaryLight text-white px-2 py-1 rounded text-xs">Dipinjam</span>
                            @else
                                <span class="bg-mediumGray text-white px-2 py-1 rounded text-xs">Dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-mediumGray">
                            <i class="fas fa-inbox text-4xl mb-2 block"></i>
                            Belum ada data peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Statistik Peminjaman per Bulan (Januari - Mei dengan data palsu) -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="p-6 border-b border-mediumGray">
        <h3 class="text-lg font-semibold text-primary">
            <i class="fas fa-chart-bar mr-2"></i> Statistik Peminjaman per Bulan (2025)
        </h3>
        <p class="text-xs text-mediumGray mt-1">Data Januari - Mei 2025</p>
    </div>
    <div class="p-6">
        <!-- Data palsu untuk Januari - Mei 2025 -->
        @php
            $dataPalsu = [
                'Januari' => ['total' => 12, 'color' => 'bg-primary'],
                'Februari' => ['total' => 8, 'color' => 'bg-primaryLight'],
                'Maret' => ['total' => 15, 'color' => 'bg-darkGray'],
                'April' => ['total' => 10, 'color' => 'bg-primary'],
                'Mei' => ['total' => 18, 'color' => 'bg-primaryLight'],
            ];
            $maxValue = max(array_column($dataPalsu, 'total'));
        @endphp
        
        <div class="flex items-end justify-around space-x-4 h-64">
            @foreach($dataPalsu as $bulan => $data)
                @php
                    $height = ($data['total'] / $maxValue) * 200;
                @endphp
                <div class="flex-1 text-center">
                    <div class="relative mb-2">
                        <div class="w-full {{ $data['color'] }} rounded-t-lg transition-all duration-500 hover:opacity-80" 
                             style="height: {{ $height }}px; min-height: 30px;">
                            <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-semibold text-darkGray">
                                {{ $data['total'] }}
                            </span>
                        </div>
                    </div>
                    <div class="text-sm font-medium text-darkGray">{{ $bulan }}</div>
                    <div class="text-xs text-mediumGray mt-1">
                        @if($loop->index == 0)
                            ▲ +2
                        @elseif($loop->index == 1)
                            ▼ -4
                        @elseif($loop->index == 2)
                            ▲ +7
                        @elseif($loop->index == 3)
                            ▼ -5
                        @else
                            ▲ +8
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Informasi tambahan statistik -->
        <div class="mt-8 pt-4 border-t border-gray-200">
            <div class="flex flex-wrap justify-center gap-6 text-sm">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-primary rounded-full mr-2"></div>
                    <span class="text-darkGray">Peminjaman Tertinggi: Mei (18 peminjaman)</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-primaryLight rounded-full mr-2"></div>
                    <span class="text-darkGray">Rata-rata: 12.6 peminjaman/bulan</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-darkGray rounded-full mr-2"></div>
                    <span class="text-darkGray">Total 5 bulan: 63 peminjaman</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Peralatan per Kategori -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-mediumGray">
        <h3 class="text-lg font-semibold text-primary">
            <i class="fas fa-chart-pie mr-2"></i> Peralatan per Kategori
        </h3>
    </div>
    <div class="p-6">
        @forelse($peralatanByKategori as $item)
        <div class="mb-5">
            <div class="flex justify-between mb-2">
                <span class="text-darkGray font-medium">{{ $item->kategori }}</span>
                <span class="text-primary font-semibold">{{ $item->total }} item</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div class="bg-primary h-3 rounded-full transition-all duration-500" 
                     style="width: {{ ($item->total / $totalPeralatan) * 100 }}%"></div>
            </div>
        </div>
        @empty
        <p class="text-center text-mediumGray py-4">Belum ada data peralatan</p>
        @endforelse
        
        @if($peralatanByKategori->count() > 0)
        <div class="mt-4 pt-3 border-t border-gray-200 text-center text-xs text-mediumGray">
            <i class="fas fa-info-circle"></i> Total {{ $totalPeralatan }} peralatan terdaftar
        </div>
        @endif
    </div>
</div>
@endsection