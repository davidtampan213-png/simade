<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->string('jurusan')->nullable()->change();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('nama');
            $table->string('fakultas')->nullable()->after('jenis_kelamin');
            $table->string('program_studi')->nullable()->after('fakultas');
            $table->enum('jenjang', ['D3', 'S1', 'S2', 'S3'])->default('S1')->after('program_studi');
            $table->tinyInteger('semester')->nullable()->after('jenjang');
            $table->string('tahun_akademik')->nullable()->after('semester');
        });

        // Ubah enum status agar mendukung Cuti jika driver MySQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE mahasiswas MODIFY COLUMN status ENUM('Aktif','Nonaktif','Cuti') DEFAULT 'Aktif'");
        }
    }

    public function down(): void
    {
        // Kembalikan status ke enum lama jika driver MySQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE mahasiswas MODIFY COLUMN status ENUM('Aktif','Nonaktif') DEFAULT 'Aktif'");
        }

        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin', 'fakultas', 'program_studi', 'jenjang', 'semester', 'tahun_akademik']);
        });
    }
};
