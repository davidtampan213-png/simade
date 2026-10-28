<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_status_histories';

    protected $fillable = [
        'mahasiswa_id',
        'semester',
        'tahun_akademik',
        'status',
        'catatan',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
