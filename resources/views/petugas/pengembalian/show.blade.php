@extends('layouts.petugas')

@section('title', 'Detail Pengembalian')
@section('submenu-active', true)

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="bg-white rounded-lg shadow p-6 space-y-4">
        <!-- Informasi Buku -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Informasi Buku</h2>
            <div class="flex items-start space-x-4">
                @if($pengembalian->peminjaman->buku->cover)
                    <img src="{{ asset('storage/' . $pengembalian->peminjaman->buku->cover) }}" alt="Cover Buku" class="w-24 h-32 object-cover rounded">
                @endif
                <div class="space-y-1">
                    <p class="text-sm text-gray-600"><strong>Judul:</strong> {{ $pengembalian->peminjaman->buku->judul }}</p>
                    <p class="text-sm text-gray-600"><strong>Kode Buku:</strong> {{ $pengembalian->peminjaman->buku->kode_buku }}</p>
                    <p class="text-sm text-gray-600"><strong>Penulis:</strong> {{ $pengembalian->peminjaman->buku->penulis }}</p>
                    <p class="text-sm text-gray-600"><strong>Penerbit:</strong> {{ $pengembalian->peminjaman->buku->penerbit }}</p>
                    <p class="text-sm text-gray-600"><strong>Deskripsi:</strong> {{ $pengembalian->peminjaman->buku->deskripsi }}</p>
                </div>
            </div>
        </div>

        <!-- Informasi Pengunjung -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Informasi Peminjam</h2>
            <p class="text-sm text-gray-600"><strong>Nama:</strong> {{ $pengembalian->peminjaman->pengunjung->nama }}</p>
            <p class="text-sm text-gray-600"><strong>NIS:</strong> {{ $pengembalian->peminjaman->pengunjung->nis }}</p>
            <p class="text-sm text-gray-600"><strong>Kelas:</strong> {{ $pengembalian->peminjaman->pengunjung->kelas }}</p>
            <p class="text-sm text-gray-600"><strong>Jenis Kelamin:</strong> {{ $pengembalian->peminjaman->pengunjung->jenis_kelamin }}</p>
            <p class="text-sm text-gray-600"><strong>Alamat:</strong> {{ $pengembalian->peminjaman->pengunjung->alamat }}</p>
        </div>

        <!-- Detail Peminjaman dan Pengembalian -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Detail Peminjaman</h2>
            <p class="text-sm text-gray-600"><strong>Tanggal Pinjam:</strong> {{ $pengembalian->peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            <p class="text-sm text-gray-600"><strong>Tenggat Kembali:</strong> {{ $pengembalian->peminjaman->tanggal_kembali->format('d M Y') }}</p>
            <p class="text-sm text-gray-600"><strong>Tanggal Pengembalian:</strong> {{ $pengembalian->tanggal_pengembalian->format('d M Y') }}</p>
            <p class="text-sm text-gray-600"><strong>Status:</strong> 
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded 
                    @if($pengembalian->keterangan == 'Dikembalikan') bg-green-100 text-green-800 
                    @elseif($pengembalian->keterangan == 'Terlambat') bg-red-100 text-red-800 
                    @else bg-yellow-100 text-yellow-800 
                    @endif">
                    {{ $pengembalian->keterangan }}
                </span>
            </p>
        </div>

        <!-- Petugas -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Petugas yang Memproses</h2>
            <p class="text-sm text-gray-600"><strong>Nama:</strong> {{ $pengembalian->petugas->name }}</p>
        </div>
        <div class="text-center">
        <a href="{{ route('petugas.pengembalian.index') }}" class="inline-block bg-[#035B73] hover:bg-[#003B4B] text-white text-[15px] px-6 py-2 rounded shadow transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
    </div>
</div>
@endsection
