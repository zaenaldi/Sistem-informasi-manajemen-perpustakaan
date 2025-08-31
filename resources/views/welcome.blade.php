@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen px-6 md:px-12 lg:px-20">
    <!-- Bagian Atas: Judul dan Gambar -->
    <div class="flex flex-col-reverse md:flex-row items-center justify-center gap-10">
        <!-- Kiri: Teks -->
        <div class="md:w-1/2 text-center md:text-left space-y-5 ml-20">
            <h1 class="text-4xl md:text-5xl font-bold text-teal-900 leading-tight">
                Ayo, Jelajahi Dunia<br>Lewat Buku!
            </h1>
            <p class="text-lg text-teal-700 font-medium">
                Selamat Datang Di Perpustakaan<br>
                <span class="font-bold">SD Negeri 02 Kuta</span>
            </p>

            <!-- Search Bar -->
            <form action="{{ route('search') }}" method="GET" class="relative w-full max-w-md mx-auto md:mx-0 mt-4">
                <input type="text" name="keyword" placeholder="Cari buku..."
                    class="w-full rounded-full py-3 px-5 pr-12 shadow text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-400" />
                <button type="submit" class="absolute right-4 top-3 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Kanan: Ilustrasi -->
        <div class="md:w-1/2 text-right space-y-5 mr-20">
            <img src="{{ asset('images/anak-membaca.png.png') }}" alt="Ilustrasi Anak Membaca"
                class="w-full max-w-sm mx-auto md:mx-0 inline-block">
        </div>
    </div>

    <!-- Koleksi Buku -->
    <div class="mt-16">
        <div class="relative flex items-center justify-center my-8">
        <!-- Garis kiri -->
            <div class="flex-1 h-2 bg-[#003B4B]"></div>
            
            <!-- Judul dengan background putih -->
            <h2 class="mx-4 text-xl font-semibold text-[#003B4B] px-4 bg-white whitespace-nowrap">
                Koleksi Buku
            </h2>
            
            <!-- Garis kanan -->
            <div class="flex-1 h-2 bg-[#003B4B]"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse ($bukus as $buku)
                <a href="{{ route('buku.detail', $buku->id) }}"
                   class="block bg-white p-3 rounded-xl shadow border hover:shadow-lg transition hover:ring-2 hover:ring-teal-500">
                    <img src="{{ $buku->cover ? asset('storage/' . $buku->cover) : asset('images/default-book.jpg') }}"
                         alt="{{ $buku->judul }}" class="w-full h-40 object-cover rounded mb-2">
                    <h3 class="font-bold text-sm text-gray-800 uppercase truncate">{{ $buku->judul }}</h3>
                    <p class="text-xs text-gray-600 truncate">{{ $buku->penulis }}</p>
                    <p class="text-xs text-gray-400">{{ $buku->tahun_terbit }}</p>
                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full inline-block mt-1">
                        {{ $buku->tersedia }} Tersedia
                    </span>
                    <p class="text-xs text-gray-500">{{ $buku->kategori->nama ?? 'Kategori Tidak Tersedia' }}</p>
                </a>
            @empty
                <p class="col-span-5 text-center text-gray-500">Belum ada buku tersedia.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($bukus->hasPages())
        <div class="mt-8">
            {{ $bukus->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
