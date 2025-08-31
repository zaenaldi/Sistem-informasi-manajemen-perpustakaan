@extends('layouts.petugas')

@section('title', 'Kelola Buku')

@section('content')
    <!-- Pencarian dan Filter -->
    <form action="{{ route('petugas.buku.index') }}" method="GET">
        <div class="mt-5 grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari kode buku/judul/penulis..." class="border p-2 rounded">
            
            <select name="kategori" class="border p-2 rounded">
                <option value="">Semua Kategori</option>
                @foreach($kategories as $kategori)
                <option value="{{ $kategori->id }}" 
                    {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama }}
                </option>
                @endforeach
            </select>

            <button type="submit" class="text-white hover:bg-[#003B4B] bg-[#035B73] p-2 rounded">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
            
            @if(request()->has('search') || request()->has('kategori'))
            <a href="{{ route('petugas.buku.index') }}" class="text-white hover:bg-[#003B4B] bg-[#035B73] p-2 rounded flex items-center justify-center">
                <i class="fas fa-times mr-2"></i>Reset
            </a>
            @endif
            <a href="{{ route('petugas.buku.create') }}" class="text-white hover:bg-[#003B4B] bg-[#035B73] p-2 rounded flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i>Tambah Buku
            </a>
        </div>
    </form>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if(session('error') && isset($buku))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Tidak dapat menghapus buku
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p>{{ session('error') }}</p>
                        @if(isset($activeLoans))
                            <p class="mt-2 font-medium">Peminjaman aktif:</p>
                            <ul class="list-disc pl-5 mt-1">
                                @foreach($activeLoans as $loan)
                                <li>
                                    {{ $loan->pengunjung->nama }} ({{ $loan->tanggal_pinjam->format('d/m/Y') }})
                                    - Kembali: {{ $loan->tanggal_kembali->format('d/m/Y') }}
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Tabel Buku -->
    @if($bukus->isEmpty())
        <div class="mt-4 bg-white rounded-lg shadow overflow-hidden text-center">
            <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 text-lg">Tidak ada buku yang ditemukan.</p>
            @if(request()->has('search') || request()->has('kategori'))
                <a href="{{ route('petugas.buku.index') }}" class="text-blue-600 hover:underline mt-4 inline-block">
                    Tampilkan semua buku
                </a>
            @endif
        </div>
    @else
    <div class="mt-4 bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-[#035B73] text-white">
                <tr>
                    <th class="py-3 px-4 text-left">No</th>
                    <th class="py-3 px-4 text-left">Kode Buku</th>
                    <th class="py-3 px-4 text-left">Cover</th>
                    <th class="py-3 px-4 text-left">Judul</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-left">Penulis</th>
                    <th class="py-3 px-4 text-left">Stok</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bukus as $buku)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="py-3 px-4">{{ $buku->kode_buku }}</td>
                    <td class="py-3 px-4">
                        @if($buku->cover)
                        <div class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded object-cover" 
                                 src="{{ Storage::url($buku->cover) }}" 
                                 alt="{{ $buku->judul }}">
                        </div>
                        @else
                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                    </td>
                    <td class="py-3 px-4">{{ $buku->judul }}</td>
                    <td class="py-3 px-4">{{ $buku->kategori->nama ?? 'umum' }}</td>
                    <td class="py-3 px-4">{{ $buku->penulis }}</td>
                    <td class="py-3 px-4 {{ $buku->tersedia < 1 ? 'text-red-500' : '' }}">
                        {{ $buku->tersedia }} <span class="text-gray-500 text-sm">/ {{ $buku->jumlah }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center space-x-2">
                            <!-- Tombol Lihat Detail -->
                            <a href="{{ route('petugas.buku.show', $buku->id) }}"
                                class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-sm flex items-center transition duration-300">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                            <!-- Tombol Edit -->
                            <a href="{{ route('petugas.buku.edit', $buku->id) }}"
                               class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-sm flex items-center transition duration-300">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('petugas.buku.destroy', $buku->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus buku ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm flex items-center transition duration-300">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $bukus->appends(request()->query())->links() }}
    </div>
    @endif
@endsection