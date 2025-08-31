<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')
                    ->orderBy('created_at', 'desc')
                    ->paginate(8);
                    
        return view('welcome', [
            'bukus' => $bukus,
            'keyword' => null,
            'kategories' => Kategori::all()
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        
        $bukus = Buku::with('kategori')
                    ->when($keyword, function($query) use ($keyword) {
                        $query->where(function($q) use ($keyword) {
                            $q->where('judul', 'like', '%'.$keyword.'%')
                              ->orWhere('penulis', 'like', '%'.$keyword.'%')
                              ->orWhere('penerbit', 'like', '%'.$keyword.'%')
                              ->orWhere('tahun_terbit', 'like', '%'.$keyword.'%');
                        });
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(8)
                    ->withQueryString();

        return view('welcome', [
            'bukus' => $bukus,
            'keyword' => $keyword,
            'kategories' => Kategori::all()
        ]);
    }

    public function detail($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('show', compact('buku'));
    }
}