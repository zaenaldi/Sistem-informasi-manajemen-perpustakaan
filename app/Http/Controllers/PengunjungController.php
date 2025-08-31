<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengunjung;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class PengunjungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengunjungs = Pengunjung::latest()->paginate(10);
        return view('petugas.pengunjung.index', compact('pengunjungs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.pengunjung.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:pengunjungs',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
        ]);
    
        Pengunjung::create($validated);
    
        return redirect()->route('petugas.pengunjung.index')
            ->with('success', 'Pengunjung berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        return view('petugas.pengunjung.edit', compact('pengunjung'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengunjung = Pengunjung::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:pengunjungs,nis,'.$pengunjung->id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
        ]);
    
        $pengunjung->update($validated);
    
        return redirect()->route('petugas.pengunjung.index')
            ->with('success', 'Data pengunjung berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengunjung = Pengunjung::with(['peminjaman' => function($query) {
            $query->where('status', 'Dipinjam')->with('buku');
        }])->findOrFail($id);

        if ($pengunjung->peminjaman->isNotEmpty()) {
            return redirect()
                ->route('petugas.pengunjung.index')
                ->with([
                    'error' => 'Pengunjung tidak dapat dihapus karena memiliki peminjaman aktif.',
                    'pengunjung' => $pengunjung
                ]);
        }

        // Use transaction for safety
        DB::transaction(function () use ($pengunjung) {
            // Delete related data if needed
            $pengunjung->peminjaman()->delete();
            $pengunjung->delete();
        });

        return redirect()
            ->route('petugas.pengunjung.index')
            ->with('success', 'Pengunjung berhasil dihapus');
    }
}