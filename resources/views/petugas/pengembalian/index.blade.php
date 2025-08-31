@extends('layouts.petugas')

@section('title', 'Pengembalian')
@section('submenu-active', true)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#003B4B]">Daftar Pengembalian</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#035B73] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Pengunjung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tenggat Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pengembalian as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($item->peminjaman->buku->cover)
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded object-cover" 
                                         src="{{ asset('storage/'.$item->peminjaman->buku->cover) }}" alt="{{ $item->peminjaman->buku->judul }}">
                                </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->peminjaman->buku->judul }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->peminjaman->buku->kode_buku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $item->peminjaman->pengunjung->nama }}</div>
                            <div class="text-sm text-gray-500">{{ $item->peminjaman->pengunjung->nis }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->peminjaman->tanggal_pinjam->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->peminjaman->tanggal_kembali->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->tanggal_pengembalian->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($item->keterangan == 'Dikembalikan') bg-green-100 text-green-800
                                        @elseif($item->keterangan == 'Terlambat') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $item->keterangan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center space-x-2">
                            <!-- Tombol Detail -->
                                <a href="{{ route('petugas.pengembalian.show', $item->id) }}" class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-sm flex items-center transition duration-300" title="Lihat Detail">
                                    Detail
                                </a>
                            <form action="{{ route('petugas.pengembalian.destroy', $item->id) }}" method="POST" class="inline">
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
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data pengembalian
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
            {{ $pengembalian->links() }}
        </div>
    </div>
</div>
@endsection