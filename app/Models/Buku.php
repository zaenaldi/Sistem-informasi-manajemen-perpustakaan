<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'jumlah',
        'deskripsi',
        'cover',
        'tersedia',
        'kategori_id'
    ];
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
    public function index()
{
    $bukus = Buku::latest()->paginate(10);
    $kategories = Kategori::all(); // Ambil semua data kategori
    
    return view('petugas.buku.index', compact('bukus', 'kategories'));
}
public function kategori()
{
    return $this->belongsTo(Kategori::class);
}
}
