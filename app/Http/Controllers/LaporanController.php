<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $peminjaman = Peminjaman::with(['buku', 'pengunjung'])
            ->when($request->bulan, fn($q) => $q->whereMonth('tanggal_pinjam', $request->bulan))
            ->when($request->tahun, fn($q) => $q->whereYear('tanggal_pinjam', $request->tahun))
            ->latest()
            ->paginate(10);

        return view('petugas.laporan.index', compact('peminjaman'));
    }

    public function cetak(Request $request)
    {
        $peminjaman = Peminjaman::with(['buku', 'pengunjung'])
            ->when($request->bulan, fn($q) => $q->whereMonth('tanggal_pinjam', $request->bulan))
            ->when($request->tahun, fn($q) => $q->whereYear('tanggal_pinjam', $request->tahun))
            ->latest()
            ->get();

        return view('petugas.laporan.cetak', compact('peminjaman'));
    }

    public function export(Request $request)
    {
        $peminjaman = Peminjaman::with(['buku', 'pengunjung'])
            ->when($request->bulan, fn($q) => $q->whereMonth('tanggal_pinjam', $request->bulan))
            ->when($request->tahun, fn($q) => $q->whereYear('tanggal_pinjam', $request->tahun))
            ->latest()
            ->get();

        $filename = 'laporan-peminjaman.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($peminjaman) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Judul Buku', 'Nama Pengunjung', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status']);

            foreach ($peminjaman as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->buku->judul,
                    $item->pengunjung->nama,
                    $item->tanggal_pinjam,
                    $item->tanggal_kembali,
                    $item->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
