<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian'; 

    protected $fillable = [
        'peminjaman_id',
        'tanggal_pengembalian',
        'denda',
        'keterangan',
        'petugas_id'
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'datetime',
    ];

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    // Relasi ke petugas
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}