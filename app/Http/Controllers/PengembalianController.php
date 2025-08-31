<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with(['peminjaman.buku', 'peminjaman.pengunjung', 'petugas'])
            ->latest()
            ->paginate(10);

        return view('petugas.pengembalian.index', compact('pengembalian'));
    }
    public function destroy(Pengembalian $pengembalian)
{
    $pengembalian->delete();
    return back()->with('success', 'Data pengembalian berhasil dihapus');
}
public function show(Pengembalian $pengembalian)
{
    $pengembalian->load(['peminjaman.buku', 'peminjaman.pengunjung', 'petugas']);
    return view('petugas.pengembalian.show', compact('pengembalian'));
}
}
