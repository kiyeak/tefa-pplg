<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Peralatan;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPengguna = Pengguna::count();
        $totalPeralatan = Peralatan::count();
        $totalPeminjaman = Peminjaman::count();
        $sedangDipinjam = Peminjaman::whereNull('tanggal_kembali')->count();
        $sudahDikembalikan = Peminjaman::whereNotNull('tanggal_kembali')->count();
        
        $recentPeminjamans = Peminjaman::with(['pengguna', 'peralatan'])
            ->latest()
            ->take(5)
            ->get();

        $peralatanByKategori = Peralatan::select('kategori', \DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();

        // Statistik peminjaman per bulan (untuk chart)
        $peminjamanPerBulan = Peminjaman::select(
            \DB::raw('MONTH(tanggal_pinjam) as bulan'),
            \DB::raw('COUNT(*) as total')
        )
        ->whereYear('tanggal_pinjam', date('Y'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        return view('dashboard', compact(
            'totalPengguna',
            'totalPeralatan',
            'totalPeminjaman',
            'sedangDipinjam',
            'sudahDikembalikan',
            'recentPeminjamans',
            'peralatanByKategori',
            'peminjamanPerBulan'
        ));
    }
}