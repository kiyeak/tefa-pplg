<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    use HasFactory;

    protected $table = 'penggunas';
    protected $fillable = ['nama', 'email', 'password', 'kelas', 'jurusan', 'no_hp', 'role'];
    protected $hidden = ['password'];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'pengguna_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
}