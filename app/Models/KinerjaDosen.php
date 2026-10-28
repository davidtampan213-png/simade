<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinerjaDosen extends Model
{
    use HasFactory;

    protected $table = 'kinerja_dosens';

    protected $fillable = [
        'dosen_id',
        'periode',
        'kategori',
        'catatan',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
