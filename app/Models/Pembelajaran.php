<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'nama_mk',
        'sks',
        'semester',
        'tahun_ajaran',
        'kelas',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
