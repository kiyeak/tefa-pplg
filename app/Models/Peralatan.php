<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    use HasFactory;

    protected $table = 'peralatans';
    protected $fillable = ['nama_peralatan', 'kategori', 'jumlah_stok', 'kondisi', 'foto'];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'peralatan_id');
    }

    // Cek stok cukup
    public function cekStok($jumlah)
    {
        return $this->jumlah_stok >= $jumlah;
    }

    // Kurangi stok
    public function kurangiStok($jumlah)
    {
        $this->decrement('jumlah_stok', $jumlah);
    }

    // Tambah stok
    public function tambahStok($jumlah)
    {
        $this->increment('jumlah_stok', $jumlah);
    }
}