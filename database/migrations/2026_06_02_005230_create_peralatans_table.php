<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peralatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peralatan');
            $table->string('kategori');
            $table->integer('jumlah_stok')->default(0);
            $table->enum('kondisi', ['baik', 'rusak', 'perbaikan'])->default('baik');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peralatans');
    }
};