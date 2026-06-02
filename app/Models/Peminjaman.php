<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';
    protected $fillable = ['pengguna_id', 'peralatan_id', 'tanggal_pinjam', 'tanggal_kembali', 'jumlah_pinjam'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function peralatan()
    {
        return $this->belongsTo(Peralatan::class, 'peralatan_id');
    }

    // Status peminjaman
    public function getStatusAttribute()
    {
        return is_null($this->tanggal_kembali) ? 'Dipinjam' : 'Dikembalikan';
    }
}