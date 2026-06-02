<?php

namespace App\Http\Controllers;

use App\Models\Peralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeralatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');
        $kondisi = $request->input('kondisi');

        $query = Peralatan::query();

        if (!empty($search)) {
            $query->where('nama_peralatan', 'like', '%' . $search . '%');
        }

        if (!empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        if (!empty($kondisi)) {
            $query->where('kondisi', $kondisi);
        }

        $peralatans = $query->latest()->paginate(10);

        $peralatans->appends([
            'search' => $search,
            'kategori' => $kategori,
            'kondisi' => $kondisi
        ]);

        $kategoriList = Peralatan::select('kategori')->distinct()->pluck('kategori');
        
        return view('peralatan.index', compact('peralatans', 'search', 'kategori', 'kondisi', 'kategoriList'));
    }

    public function create()
    {
        // Ambil SEMUA kategori unik dari database
        $kategoriList = Peralatan::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        
        // Debug: cek apakah data ada
        // dd($kategoriList);
        
        return view('peralatan.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peralatan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jumlah_stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak,perbaikan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('peralatan', 'public');
        }

        Peralatan::create($data);
        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil ditambahkan');
    }

    public function show(Peralatan $peralatan)
    {
        return view('peralatan.show', compact('peralatan'));
    }

    public function edit(Peralatan $peralatan)
    {
        // Ambil SEMUA kategori unik dari database
        $kategoriList = Peralatan::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        
        // Debug: cek apakah data ada
        // dd($kategoriList);
        
        return view('peralatan.edit', compact('peralatan', 'kategoriList'));
    }

    public function update(Request $request, Peralatan $peralatan)
    {
        $request->validate([
            'nama_peralatan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jumlah_stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak,perbaikan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            if ($peralatan->foto) {
                Storage::disk('public')->delete($peralatan->foto);
            }
            $data['foto'] = $request->file('foto')->store('peralatan', 'public');
        }

        $peralatan->update($data);
        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil diupdate');
    }

    public function destroy(Peralatan $peralatan)
    {
        if ($peralatan->foto) {
            Storage::disk('public')->delete($peralatan->foto);
        }
        $peralatan->delete();
        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil dihapus');
    }
}