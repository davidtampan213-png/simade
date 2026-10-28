<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->tinyInteger('semester');
            $table->string('tahun_akademik');
            $table->enum('status', ['Aktif', 'Nonaktif', 'Cuti']);
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->unique(['mahasiswa_id', 'semester', 'tahun_akademik'], 'msh_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_status_histories');
    }
};
