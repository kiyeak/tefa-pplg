<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Peralatan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $peminjamans = Peminjaman::with(['pengguna', 'peralatan'])
            ->when($search, function ($query, $search) {
                $query->whereHas('pengguna', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })->orWhereHas('peralatan', function ($q) use ($search) {
                    $q->where('nama_peralatan', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                if ($status == 'Dipinjam') {
                    $query->whereNull('tanggal_kembali');
                } elseif ($status == 'Dikembalikan') {
                    $query->whereNotNull('tanggal_kembali');
                }
            })
            ->latest()
            ->paginate(10);

        return view('peminjaman.index', compact('peminjamans', 'search', 'status'));
    }

    // METHOD JSON UNTUK FILTER OTOMATIS (TANPA TOMBOL)
    public function getData(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $peminjamans = Peminjaman::with(['pengguna', 'peralatan'])
            ->when($search, function ($query, $search) {
                $query->whereHas('pengguna', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })->orWhereHas('peralatan', function ($q) use ($search) {
                    $q->where('nama_peralatan', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                if ($status == 'Dipinjam') {
                    $query->whereNull('tanggal_kembali');
                } elseif ($status == 'Dikembalikan') {
                    $query->whereNotNull('tanggal_kembali');
                }
            })
            ->latest()
            ->get();

        return response()->json($peminjamans);
    }

    public function create()
    {
        $penggunas = Pengguna::all();
        $peralatans = Peralatan::all();
        return view('peminjaman.create', compact('penggunas', 'peralatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengguna_id' => 'required|exists:penggunas,id',
            'peralatan_id' => 'required|exists:peralatans,id',
            'tanggal_pinjam' => 'required|date',
            'jumlah_pinjam' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $peralatan = Peralatan::find($request->peralatan_id);
            
            if (!$peralatan->cekStok($request->jumlah_pinjam)) {
                return back()->withErrors(['jumlah_pinjam' => 'Stok tidak mencukupi! Sisa stok: ' . $peralatan->jumlah_stok]);
            }

            Peminjaman::create([
                'pengguna_id' => $request->pengguna_id,
                'peralatan_id' => $request->peralatan_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'jumlah_pinjam' => $request->jumlah_pinjam,
            ]);

            $peralatan->kurangiStok($request->jumlah_pinjam);
            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $penggunas = Pengguna::all();
        $peralatans = Peralatan::all();
        return view('peminjaman.edit', compact('peminjaman', 'penggunas', 'peralatans'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'pengguna_id' => 'required|exists:penggunas,id',
            'peralatan_id' => 'required|exists:peralatans,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'jumlah_pinjam' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $oldPeralatan = $peminjaman->peralatan;
            $newPeralatan = Peralatan::find($request->peralatan_id);
            
            if ($peminjaman->peralatan_id != $request->peralatan_id) {
                $oldPeralatan->tambahStok($peminjaman->jumlah_pinjam);
                
                if (!$newPeralatan->cekStok($request->jumlah_pinjam)) {
                    return back()->withErrors(['jumlah_pinjam' => 'Stok tidak mencukupi! Sisa stok: ' . $newPeralatan->jumlah_stok]);
                }
                $newPeralatan->kurangiStok($request->jumlah_pinjam);
            } else {
                $selisih = $request->jumlah_pinjam - $peminjaman->jumlah_pinjam;
                if ($selisih > 0) {
                    if (!$newPeralatan->cekStok($selisih)) {
                        return back()->withErrors(['jumlah_pinjam' => 'Stok tidak mencukupi! Sisa stok: ' . $newPeralatan->jumlah_stok]);
                    }
                    $newPeralatan->kurangiStok($selisih);
                } elseif ($selisih < 0) {
                    $newPeralatan->tambahStok(abs($selisih));
                }
            }

            $peminjaman->update($request->all());
            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

public function destroy(Peminjaman $peminjaman)
{
    DB::beginTransaction();
    try {
        // ✅ Cek: jika belum dikembalikan, jangan hapus!
        if (is_null($peminjaman->tanggal_kembali)) {
            return back()->with('error', 'Tidak dapat menghapus peminjaman yang masih aktif! Kembalikan barang terlebih dahulu.');
        }
        
        // Hanya peminjaman yang sudah dikembalikan yang boleh dihapus
        $peminjaman->delete();
        DB::commit();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Terjadi kesalahan']);
    }
}

    public function kembalikan($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::findOrFail($id);
            
            if (!is_null($peminjaman->tanggal_kembali)) {
                return back()->with('error', 'Barang sudah dikembalikan sebelumnya');
            }

            $peminjaman->update([
                'tanggal_kembali' => now()->toDateString(),
            ]);
            
            $peminjaman->peralatan->tambahStok($peminjaman->jumlah_pinjam);
            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Barang berhasil dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan']);
        }
    }
}