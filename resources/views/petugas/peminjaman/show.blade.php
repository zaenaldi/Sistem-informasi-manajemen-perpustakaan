@extends('layouts.petugas')

@section('title', 'Detail Peminjaman')
@section('submenu-active', true)

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="bg-white rounded-lg shadow p-6 space-y-4">
        <!-- Informasi Buku -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Informasi Buku</h2>
            <div class="flex items-start space-x-4">
                @if($peminjaman->buku->cover)
                    <img src="{{ asset('storage/' . $peminjaman->buku->cover) }}" alt="Cover Buku" class="w-24 h-32 object-cover rounded">
                @endif
                <div class="space-y-1">
                    <p class="text-sm text-gray-600"><strong>Judul:</strong> {{ $peminjaman->buku->judul }}</p>
                    <p class="text-sm text-gray-600"><strong>Kode Buku:</strong> {{ $peminjaman->buku->kode_buku }}</p>
                    <p class="text-sm text-gray-600"><strong>Penulis:</strong> {{ $peminjaman->buku->penulis }}</p>
                    <p class="text-sm text-gray-600"><strong>Penerbit:</strong> {{ $peminjaman->buku->penerbit }}</p>
                    <p class="text-sm text-gray-600"><strong>Deskripsi:</strong> {{ $peminjaman->buku->deskripsi }}</p>
                </div>
            </div>
        </div>

        <!-- Informasi Peminjam -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Informasi Peminjam</h2>
            <p class="text-sm text-gray-600"><strong>Nama:</strong> {{ $peminjaman->pengunjung->nama }}</p>
            <p class="text-sm text-gray-600"><strong>NIS:</strong> {{ $peminjaman->pengunjung->nis }}</p>
            <p class="text-sm text-gray-600"><strong>Kelas:</strong> {{ $peminjaman->pengunjung->kelas }}</p>
            <p class="text-sm text-gray-600"><strong>Jenis Kelamin:</strong> {{ $peminjaman->pengunjung->jenis_kelamin }}</p>
            <p class="text-sm text-gray-600"><strong>Alamat:</strong> {{ $peminjaman->pengunjung->alamat }}</p>
        </div>

        <!-- Detail Peminjaman -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Detail Peminjaman</h2>
            <p class="text-sm text-gray-600"><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            <p class="text-sm text-gray-600"><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_kembali->format('d M Y') }}</p>
            <p class="text-sm text-gray-600"><strong>Status:</strong> 
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded 
                    @if($peminjaman->status == 'Dipinjam') bg-yellow-100 text-yellow-800 
                    @elseif($peminjaman->status == 'Dikembalikan') bg-green-100 text-green-800 
                    @else bg-red-100 text-red-800 
                    @endif">
                    {{ $peminjaman->status }}
                </span>
            </p>
            @if($peminjaman->tanggal_pengembalian)
            <p class="text-sm text-gray-600"><strong>Tanggal Pengembalian:</strong> {{ $peminjaman->tanggal_pengembalian->format('d M Y') }}</p>
            @endif
        </div>

        <!-- Petugas -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Petugas</h2>
            <p class="text-sm text-gray-600"><strong>Nama:</strong> {{ $peminjaman->petugas->name }}</p>
        </div>
        <div class="text-center">
            <a href="{{ route('petugas.peminjaman.index') }}"
               class="inline-block bg-[#035B73] hover:bg-[#003B4B] text-white text-[15px] px-6 py-2 rounded shadow transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
