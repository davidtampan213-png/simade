<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaLaporanController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\PenelitianController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\KinerjaDosenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pilih-role', [\App\Http\Controllers\RoleController::class, 'index'])->name('pilih-role');
    Route::post('/pilih-role', [\App\Http\Controllers\RoleController::class, 'setRole']);

    Route::middleware(['active_role:mahasiswa'])->group(function () {
        Route::get('/dashboard/mahasiswa', [DashboardController::class, 'mahasiswa'])->name('dashboard.mahasiswa');

        // Admin Only (CRUD mahasiswa: create, store, edit, update, destroy)
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
            Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
            Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
            Route::put('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
            Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
        });

        // Data Mahasiswa — bisa diakses admin dan dosen
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/mahasiswa/export', [MahasiswaController::class, 'export'])->name('mahasiswa.export');
        Route::get('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');

        // Laporan — bisa diakses admin dan dosen
        Route::get('/mahasiswa-laporan', [MahasiswaLaporanController::class, 'index'])->name('mahasiswa.laporan');
        Route::get('/mahasiswa-laporan/export', [MahasiswaLaporanController::class, 'export'])->name('mahasiswa.laporan.export');
        Route::get('/mahasiswa-laporan/fakultas/{fakultas}', [MahasiswaLaporanController::class, 'fakultas'])->name('mahasiswa.laporan.fakultas');
    });

    Route::middleware(['active_role:dosen'])->group(function () {
        Route::get('/dashboard/dosen', [DashboardController::class, 'dosen'])->name('dashboard.dosen');

        // Admin Only (within dosen role context)
        Route::middleware(['role:admin'])->group(function () {
            Route::resource('dosen', DosenController::class);

            // Penelitian
            Route::get('dosen/{dosen_id}/penelitian', [PenelitianController::class, 'index'])->name('dosen.penelitian.index');
            Route::get('dosen/{dosen_id}/penelitian/create', [PenelitianController::class, 'create'])->name('dosen.penelitian.create');
            Route::post('dosen/{dosen_id}/penelitian', [PenelitianController::class, 'store'])->name('dosen.penelitian.store');
            Route::get('dosen/{dosen_id}/penelitian/{penelitian}/edit', [PenelitianController::class, 'edit'])->name('dosen.penelitian.edit');
            Route::put('dosen/{dosen_id}/penelitian/{penelitian}', [PenelitianController::class, 'update'])->name('dosen.penelitian.update');
            Route::delete('dosen/{dosen_id}/penelitian/{penelitian}', [PenelitianController::class, 'destroy'])->name('dosen.penelitian.destroy');

            // Pembelajaran
            Route::get('dosen/{dosen_id}/pembelajaran', [PembelajaranController::class, 'index'])->name('dosen.pembelajaran.index');
            Route::get('dosen/{dosen_id}/pembelajaran/create', [PembelajaranController::class, 'create'])->name('dosen.pembelajaran.create');
            Route::post('dosen/{dosen_id}/pembelajaran', [PembelajaranController::class, 'store'])->name('dosen.pembelajaran.store');
            Route::get('dosen/{dosen_id}/pembelajaran/{pembelajaran}/edit', [PembelajaranController::class, 'edit'])->name('dosen.pembelajaran.edit');
            Route::put('dosen/{dosen_id}/pembelajaran/{pembelajaran}', [PembelajaranController::class, 'update'])->name('dosen.pembelajaran.update');
            Route::delete('dosen/{dosen_id}/pembelajaran/{pembelajaran}', [PembelajaranController::class, 'destroy'])->name('dosen.pembelajaran.destroy');

            // Kinerja
            Route::get('dosen/{dosen_id}/kinerja', [KinerjaDosenController::class, 'index'])->name('dosen.kinerja.index');
            Route::get('dosen/{dosen_id}/kinerja/create', [KinerjaDosenController::class, 'create'])->name('dosen.kinerja.create');
            Route::post('dosen/{dosen_id}/kinerja', [KinerjaDosenController::class, 'store'])->name('dosen.kinerja.store');
            Route::get('dosen/{dosen_id}/kinerja/{kinerja}/edit', [KinerjaDosenController::class, 'edit'])->name('dosen.kinerja.edit');
            Route::put('dosen/{dosen_id}/kinerja/{kinerja}', [KinerjaDosenController::class, 'update'])->name('dosen.kinerja.update');
            Route::delete('dosen/{dosen_id}/kinerja/{kinerja}', [KinerjaDosenController::class, 'destroy'])->name('dosen.kinerja.destroy');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
