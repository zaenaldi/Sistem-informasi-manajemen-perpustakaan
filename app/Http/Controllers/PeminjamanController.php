<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengunjung;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['buku', 'pengunjung', 'petugas'])
            ->where('status', 'Dipinjam')
            ->latest()
            ->paginate(10);

        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $bukus = Buku::where('tersedia', '>', 0)->get();
        $pengunjungs = Pengunjung::all();
        
        return view('petugas.peminjaman.create', compact('bukus', 'pengunjungs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'pengunjung_id' => 'required|exists:pengunjungs,id',
            'tanggal_kembali' => 'required|date|after_or_equal:today'
        ]);

        $buku = Buku::findOrFail($request->buku_id);
        $pengunjung = Pengunjung::findOrFail($request->pengunjung_id);

        if ($buku->tersedia < 1) {
            return back()->with('error', 'Stok buku tidak tersedia');
        }

        $peminjaman = Peminjaman::create([
            'buku_id' => $request->buku_id,
            'pengunjung_id' => $request->pengunjung_id,
            'petugas_id' => Auth::id(),
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_kembali' => Carbon::parse($request->tanggal_kembali),
            'status' => 'Dipinjam'
        ]);

        $buku->decrement('tersedia');

        return redirect()->route('petugas.peminjaman.index')
                        ->with('success', 'Peminjaman berhasil dicatat');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $bukus = Buku::where('tersedia', '>', 0)->get();
        $pengunjungs = Pengunjung::all();
        
        return view('petugas.peminjaman.edit', compact('peminjaman', 'bukus', 'pengunjungs'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'pengunjung_id' => 'required|exists:pengunjungs,id',
            'tanggal_kembali' => 'required|date|after_or_equal:today'
        ]);

        // Jika buku diubah, update stok
        if ($peminjaman->buku_id != $request->buku_id) {
            // Kembalikan stok buku lama
            $peminjaman->buku->increment('tersedia');
            
            // Kurangi stok buku baru
            $bukuBaru = Buku::findOrFail($request->buku_id);
            $bukuBaru->decrement('tersedia');
        }

        $peminjaman->update([
            'buku_id' => $request->buku_id,
            'pengunjung_id' => $request->pengunjung_id,
            'tanggal_kembali' => Carbon::parse($request->tanggal_kembali)
        ]);

        return redirect()->route('petugas.peminjaman.index')
                        ->with('success', 'Peminjaman berhasil diperbarui');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Kembalikan stok buku jika status masih Dipinjam
        if ($peminjaman->status == 'Dipinjam') {
            $peminjaman->buku->increment('tersedia');
        }

        $peminjaman->delete();

        return redirect()->route('petugas.peminjaman.index')
                        ->with('success', 'Peminjaman berhasil dihapus');
    }

    public function pengembalian(Peminjaman $peminjaman)
    {
        if ($peminjaman->status != 'Dipinjam') {
            return back()->with('error', 'Buku sudah dikembalikan sebelumnya');
        }

        $terlambat = Carbon::now() > $peminjaman->tanggal_kembali ? 
                    Carbon::now()->diffInDays($peminjaman->tanggal_kembali) : 0;
        $status = $terlambat > 0 ? 'Terlambat' : 'Dikembalikan';

        $peminjaman->update([
            'tanggal_pengembalian' => Carbon::now(),
            'status' => $status,
        ]);

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'petugas_id' => Auth::id(),
            'tanggal_pengembalian' => Carbon::now(),
            'keterangan' => $status
        ]);

        $peminjaman->buku->increment('tersedia');

        return back()->with('success', 'Pengembalian berhasil dicatat');
    }
    public function show(Peminjaman $peminjaman)
{
    $peminjaman->load(['buku', 'pengunjung', 'petugas']);
    return view('petugas.peminjaman.show', compact('peminjaman'));
}
}