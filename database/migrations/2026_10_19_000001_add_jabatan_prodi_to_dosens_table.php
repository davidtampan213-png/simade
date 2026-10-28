<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosens', function (Blueprint $table) {
            $table->enum('jabatan', [
                'Rektor',
                'Dekan',
                'Kepala Prodi',
                'Guru Besar',
                'Lektor Kepala',
                'Lektor',
                'Asisten Ahli',
            ])->nullable()->after('nama');

            $table->string('prodi')->nullable()->after('jabatan');
        });
    }

    public function down(): void
    {
        Schema::table('dosens', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'prodi']);
        });
    }
};
