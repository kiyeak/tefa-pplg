@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6 flex-wrap gap-4">
    <h1 class="text-2xl font-bold text-primary">Data Pengguna</h1>
    <a href="{{ route('pengguna.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
        <i class="fas fa-plus"></i> Tambah Pengguna
    </a>
</div>

<!-- Search -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex gap-4">
        <input type="text" name="search" placeholder="Cari nama, kelas, atau jurusan..." value="{{ request('search') }}" 
            class="flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
            <i class="fas fa-search"></i> Cari
        </button>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-primary text-white">
            <tr class="text-left">
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Kelas</th>
                <th class="px-6 py-3">Jurusan</th>
                <th class="px-6 py-3">No HP</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($penggunas as $item)
            <tr>
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">{{ $item->nama }}</td>
                <td class="px-6 py-4">{{ $item->kelas }}</td>
                <td class="px-6 py-4">{{ $item->jurusan }}</td>
                <td class="px-6 py-4">{{ $item->no_hp }}</td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('pengguna.show', $item->id) }}" class="text-primary hover:text-primaryLight">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('pengguna.edit', $item->id) }}" class="text-darkGray hover:text-mediumGray">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('pengguna.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-primary hover:text-primaryLight" onclick="return confirm('Yakin hapus?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $penggunas->links() }}
</div>
@endsection