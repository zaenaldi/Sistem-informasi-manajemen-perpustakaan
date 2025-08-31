@extends('layouts.petugas')

@section('title', 'Peminjaman')
@section('submenu-active', true)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#003B4B]">Daftar Peminjaman</h1>
        <a href="{{ route('petugas.peminjaman.create') }}" class="bg-[#035B73] hover:bg-[#003B4B] text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Peminjaman
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-4 bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#035B73] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Pengunjung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tenggat Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($peminjaman as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($item->buku->cover)
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded object-cover" 
                                         src="{{ asset('storage/'.$item->buku->cover) }}" alt="{{ $item->buku->judul }}">
                                </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->buku->judul }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->buku->kode_buku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $item->pengunjung->nama }}</div>
                            <div class="text-sm text-gray-500">{{ $item->pengunjung->nis }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->tanggal_pinjam->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->tanggal_kembali->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($item->status == 'Dipinjam') bg-yellow-100 text-yellow-800
                                        @elseif($item->status == 'Dikembalikan') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center space-x-2">

                                @if($item->status == 'Dipinjam')
                                <!-- Tombol Pengembalian (tetap pakai ikon centang) -->
                                <form action="{{ route('peminjaman.pengembalian', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" title="Kembalikan">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif

                                <!-- Tombol Edit -->
                                <a href="{{ route('petugas.peminjaman.edit', $item->id) }}" 
                                class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-sm flex items-center transition duration-300" title="Edit">
                                    Edit
                                </a>

                                <!-- Tombol Detail -->
                                <a href="{{ route('petugas.peminjaman.show', $item->id) }}" class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-sm flex items-center transition duration-300" title="Lihat Detail">
                                    Detail
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('petugas.peminjaman.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm flex items-center transition duration-300" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
            {{ $peminjaman->links() }}
        </div>
    </div>
</div>
@endsection