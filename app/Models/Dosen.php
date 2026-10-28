<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'prodi',
        'jurusan',
        'status',
        'no_hp',
        'alamat',
    ];

    public function penelitians()
    {
        return $this->hasMany(Penelitian::class);
    }

    public function pembelajarans()
    {
        return $this->hasMany(Pembelajaran::class);
    }

    public function kinerjaDosens()
    {
        return $this->hasMany(KinerjaDosen::class);
    }
}
