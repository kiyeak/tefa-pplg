<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    // Export ke CSV (Excel)
    public function exportExcel()
    {
        $data = Peminjaman::with(['pengguna', 'peralatan'])->get();
        
        $filename = 'laporan_peminjaman_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Header CSV (UTF-8 BOM untuk support bahasa Indonesia)
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['ID', 'Pengguna', 'Email', 'Kelas', 'Jurusan', 'Peralatan', 'Kategori', 'Jumlah', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status']);
        
        // Data
        foreach ($data as $row) {
            fputcsv($output, [
                $row->id,
                $row->pengguna->nama,
                $row->pengguna->email,
                $row->pengguna->kelas,
                $row->pengguna->jurusan,
                $row->peralatan->nama_peralatan,
                $row->peralatan->kategori,
                $row->jumlah_pinjam,
                $row->tanggal_pinjam,
                $row->tanggal_kembali ?? '-',
                $row->status,
            ]);
        }
        
        fclose($output);
        exit;
    }

    // Export ke HTML (print to PDF)
    public function exportPdf()
    {
        $data = Peminjaman::with(['pengguna', 'peralatan'])->get();
        return view('exports.peminjaman_pdf', compact('data'));
    }
}