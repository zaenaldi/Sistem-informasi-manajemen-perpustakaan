@extends('layouts.admin')

@section('title', 'Kelola Petugas')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header dengan Tombol Tambah -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Petugas</h2>
            <a href="{{ route('admin.petugas.create') }}" class="bg-[#035B73] hover:bg-[#003B4B] text-white px-4 py-2 rounded-md flex items-center transition duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Petugas
            </a>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Responsif -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#035B73] ">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($petugas as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.petugas.edit', $item->id) }}" 
                                   class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-sm flex items-center transition duration-300">
                                   <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                   </svg>
                                   Edit
                                </a>
                                
                                <!-- Tombol Delete -->
                                <form action="{{ route('admin.petugas.destroy', $item->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm flex items-center transition duration-300"
                                            onclick="return confirm('Yakin ingin menghapus petugas ini?')">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data petugas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($petugas->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $petugas->firstItem() }}</span> 
                    sampai <span class="font-medium">{{ $petugas->lastItem() }}</span> 
                    dari <span class="font-medium">{{ $petugas->total() }}</span> hasil
                </div>
                <div class="flex space-x-2">
                    @if($petugas->onFirstPage())
                        <span class="px-3 py-1 rounded bg-gray-200 text-gray-500 cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $petugas->previousPageUrl() }}" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Sebelumnya</a>
                    @endif

                    @if($petugas->hasMorePages())
                        <a href="{{ $petugas->nextPageUrl() }}" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Selanjutnya</a>
                    @else
                        <span class="px-3 py-1 rounded bg-gray-200 text-gray-500 cursor-not-allowed">Selanjutnya</span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection