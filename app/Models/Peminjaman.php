<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'buku_id',
        'pengunjung_id',
        'petugas_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_pengembalian',
        'status',
        'denda',
        'keterangan'
    ];

    protected $casts = [
    'tanggal_pinjam' => 'datetime',
    'tanggal_kembali' => 'datetime',
    'tanggal_pengembalian' => 'datetime',
    ];


    // Relasi
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // Hitung denda otomatis
    public function hitungDenda()
    {
        if ($this->status != 'Dipinjam' && $this->tanggal_pengembalian > $this->tanggal_kembali) {
            $terlambat = $this->tanggal_pengembalian->diffInDays($this->tanggal_kembali);
            $this->denda = $terlambat * 5000; // Rp 5.000 per hari
            $this->save();
        }
        return $this->denda;
    }

    // Status warna untuk tampilan
    public function getStatusColorAttribute()
    {
        return [
            'Dipinjam' => 'blue',
            'Dikembalikan' => 'green',
            'Terlambat' => 'red'
        ][$this->status] ?? 'gray';
    }
}