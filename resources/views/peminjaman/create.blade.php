@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-primary">Tambah Peminjaman</h1>

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-darkGray mb-2">Pengguna <span class="text-primary">*</span></label>
                <select name="pengguna_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                    <option value="">Pilih Pengguna</option>
                    @foreach($penggunas as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->kelas }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Peralatan <span class="text-primary">*</span></label>
                <select name="peralatan_id" id="peralatan_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                    <option value="">Pilih Peralatan</option>
                    @foreach($peralatans as $item)
                        <option value="{{ $item->id }}" data-stok="{{ $item->jumlah_stok }}">
                            {{ $item->nama_peralatan }} (Stok: {{ $item->jumlah_stok }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Jumlah Pinjam <span class="text-primary">*</span></label>
                <input type="number" name="jumlah_pinjam" id="jumlah_pinjam" min="1" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                <p id="stok_warning" class="text-primary text-sm mt-1 hidden">Stok tidak mencukupi!</p>
            </div>
            <div>
                <label class="block text-darkGray mb-2">Tanggal Pinjam <span class="text-primary">*</span></label>
                <input type="date" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
            </div>
        </div>
        <div class="mt-6 flex space-x-2">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('peminjaman.index') }}" class="bg-darkGray text-white px-6 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
    const peralatanSelect = document.getElementById('peralatan_id');
    const jumlahInput = document.getElementById('jumlah_pinjam');
    const warning = document.getElementById('stok_warning');
    
    function cekStok() {
        const selectedOption = peralatanSelect.options[peralatanSelect.selectedIndex];
        const stok = selectedOption ? parseInt(selectedOption.dataset.stok) : 0;
        const jumlah = parseInt(jumlahInput.value) || 0;
        
        if (jumlah > stok && stok > 0) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
    }
    
    peralatanSelect.addEventListener('change', cekStok);
    jumlahInput.addEventListener('input', cekStok);
</script>
@endsection