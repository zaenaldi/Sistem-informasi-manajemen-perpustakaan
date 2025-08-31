<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');

        $bukus = Buku::query()
            ->with('kategori')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('judul', 'like', '%'.$search.'%')
                      ->orWhere('penulis', 'like', '%'.$search.'%')
                      ->orWhere('penerbit', 'like', '%'.$search.'%')
                      ->orWhere('kode_buku', 'like', '%'.$search.'%');
                });
            })
            ->when($kategori, function($query) use ($kategori) {
                $query->where('kategori_id', $kategori);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategories = Kategori::all();
        
        return view('petugas.buku.index', compact('bukus', 'kategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategories = Kategori::all();
        return view('petugas.buku.create', compact('kategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|unique:bukus',
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'jumlah' => 'required|integer|min:1',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'kategori_baru' => 'nullable|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if (!empty($validated['kategori_baru'])) {
            $kategoriBaru = Kategori::create(['nama' => $validated['kategori_baru']]);
            $validated['kategori_id'] = $kategoriBaru->id;
        }

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('buku-covers', 'public');
        }

        $validated['tersedia'] = $validated['jumlah'];

        Buku::create($validated);

        return redirect()->route('petugas.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('petugas.buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategories = Kategori::all();
        return view('petugas.buku.edit', compact('buku', 'kategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'jumlah' => 'required|integer|min:1',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'kategori_baru' => 'nullable|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            if (!empty($validated['kategori_baru'])) {
                $kategoriBaru = Kategori::create(['nama' => $validated['kategori_baru']]);
                $validated['kategori_id'] = $kategoriBaru->id;
            }

            $oldCover = null;
            if ($request->hasFile('cover')) {
                $oldCover = $buku->cover;
                $validated['cover'] = $request->file('cover')->store('buku-covers', 'public');
            }

            $buku->update($validated);

            if ($oldCover) {
                Storage::disk('public')->delete($oldCover);
            }

            DB::commit();

            return redirect()->route('petugas.buku.index')
                             ->with('success', 'Buku berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            // Delete new cover if update failed
            if (isset($validated['cover'])) {
                Storage::disk('public')->delete($validated['cover']);
            }
            return back()->withInput()->with('error', 'Gagal memperbarui buku: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::with(['peminjaman' => function($query) {
            $query->where('status', 'Dipinjam')->with('pengunjung');
        }])->findOrFail($id);

        if ($buku->peminjaman->isNotEmpty()) {
            return redirect()
                ->route('petugas.buku.index')
                ->with([
                    'error' => 'Buku tidak dapat dihapus karena masih dipinjam.',
                    'buku' => $buku,
                    'activeLoans' => $buku->peminjaman
                ]);
        }

        try {
            DB::beginTransaction();
            
            $coverPath = $buku->cover;
            $buku->delete();

            if ($coverPath) {
                Storage::disk('public')->delete($coverPath);
            }

            DB::commit();

            return redirect()
                ->route('petugas.buku.index')
                ->with('success', 'Buku berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('petugas.buku.index')
                ->with('error', 'Gagal menghapus buku: '.$e->getMessage());
        }
    }
}