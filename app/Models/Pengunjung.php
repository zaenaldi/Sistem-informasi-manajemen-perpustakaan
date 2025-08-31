<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'jenis_kelamin',
        'alamat'
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Accessor untuk jenis kelamin lengkap
    public function getJenisKelaminLengkapAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
