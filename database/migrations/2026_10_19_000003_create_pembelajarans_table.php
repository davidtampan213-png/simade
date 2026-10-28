<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembelajarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
            $table->string('nama_mk');
            $table->unsignedTinyInteger('sks');
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('tahun_ajaran'); // contoh: 2024/2025
            $table->string('kelas');       // contoh: A, B, TI-3A
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelajarans');
    }
};
