@extends('layouts.petugas')

@section('title', 'Detail Buku')

@section('content')
<div class="px-4 py-6 ">
    <div class="bg-white rounded-lg shadow border border-gray-100 p-8 w-full max-w-7xl mx-auto">

        <!-- Judul di Tengah -->
        <h2 class="text-center text-3xl font-bold uppercase text-[#003B4B] mb-8 tracking-wide">
            {{ $buku->judul }}
        </h2>

        <!-- Grid Konten -->
        <div class="grid grid-cols-1 md:grid-cols-[350px_1fr] gap-8 mb-10 max-w-5xl mx-auto">
            
            <!-- Cover Buku -->
            <div class="flex justify-center md:justify-start">
                @if($buku->cover)
                    <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}"
                         class="w-72 h-[420px] object-cover rounded shadow">
                @else
                    <div class="w-72 h-[420px] bg-gray-200 flex items-center justify-center rounded">
                        <i class="fas fa-book text-6xl text-gray-400"></i>
                    </div>
                @endif
            </div>

            <!-- Informasi Buku + Deskripsi -->
            <div class="text-[17px] text-gray-800 space-y-4">
                <div class="space-y-2">
                    <p><strong>Kode Buku:</strong> {{ $buku->kode_buku }}</p>
                    <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                    <p><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
                    <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
                    <p><strong>Jumlah Buku:</strong> {{ $buku->jumlah }}</p>
                    <p><strong>Stok Tersedia:</strong> {{ $buku->tersedia }}</p>
                    <p><strong>Kategori:</strong> {{ $buku->kategori->nama ?? 'Umum' }}</p>
                </div>

                <!-- Deskripsi -->
                @if($buku->deskripsi)
                <div>
                    <h3 class="text-center text-lg font-bold text-[#003B4B] mb-2">Deskripsi</h3>
                    <p class="text-justify leading-relaxed text-gray-700">
                        {{ $buku->deskripsi }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Tombol -->
        <div class="text-center">
            <a href="{{ route('petugas.buku.index') }}"
               class="inline-block bg-[#035B73] hover:bg-[#003B4B] text-white text-[15px] px-6 py-2 rounded shadow transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
