<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'judul',
        'tahun',
        'sumber_dana',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
