<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        $penggunas = [
            [
                'nama' => 'Admin Lab',
                'email' => 'admin@tefa.com',
                'password' => Hash::make('admin123'),
                'kelas' => 'XII PPLG 1',
                'jurusan' => 'PPLG',
                'no_hp' => '081234567890',
                'role' => 'admin'
            ],
            [
                'nama' => 'Ahmad Fauzan',
                'email' => 'ahmad@tefa.com',
                'password' => Hash::make('user123'),
                'kelas' => 'XI PPLG 1',
                'jurusan' => 'PPLG',
                'no_hp' => '081234567891',
                'role' => 'user'
            ],
            [
                'nama' => 'Rizky Pratama',
                'email' => 'rizky@tefa.com',
                'password' => Hash::make('user123'),
                'kelas' => 'XI PPLG 2',
                'jurusan' => 'PPLG',
                'no_hp' => '081234567892',
                'role' => 'user'
            ],
            [
                'nama' => 'Dinda Putri',
                'email' => 'dinda@tefa.com',
                'password' => Hash::make('user123'),
                'kelas' => 'XI PPLG 1',
                'jurusan' => 'PPLG',
                'no_hp' => '081234567893',
                'role' => 'user'
            ],
        ];

        foreach ($penggunas as $item) {
            Pengguna::create($item);
        }
    }
}