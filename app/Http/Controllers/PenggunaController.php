<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $penggunas = Pengguna::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('kelas', 'like', "%{$search}%")
                         ->orWhere('jurusan', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->latest()->paginate(10);
        
        return view('pengguna.index', compact('penggunas', 'search'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas',
            'password' => 'required|min:6',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'role' => 'required|in:admin,user',
        ]);

        Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function show(Pengguna $pengguna)
    {
        return view('pengguna.show', compact('pengguna'));
    }

    public function edit(Pengguna $pengguna)
    {
        return view('pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, Pengguna $pengguna)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email,' . $pengguna->id,
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'role' => 'required|in:admin,user',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diupdate');
    }

    public function destroy(Pengguna $pengguna)
    {
        // Cegah menghapus admin terakhir
        if ($pengguna->role == 'admin' && Pengguna::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus admin terakhir!');
        }
        
        $pengguna->delete();
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus');
    }
}