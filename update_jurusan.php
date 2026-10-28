<?php

$allowed = ['Teknik Informatika', 'Teknik Mesin', 'Manajemen Informatika', 'Arsitek', 'Teknik Sipil'];

App\Models\Mahasiswa::all()->each(function($m) use ($allowed) {
    $m->jurusan = $allowed[array_rand($allowed)];
    $m->save();
});

App\Models\Dosen::all()->each(function($d) use ($allowed) {
    $d->jurusan = $allowed[array_rand($allowed)];
    $d->save();
});
