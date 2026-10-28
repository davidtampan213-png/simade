<?php
App\Models\Dosen::all()->each(function($d) {
    $d->status = collect(['Aktif', 'Aktif', 'Aktif', 'Nonaktif'])->random();
    $d->save();
});
