@extends('layouts.petugas')

@section('title', 'Kelola Pengunjung')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header with Add Button -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Pengunjung</h2>
            <a href="{{ route('petugas.pengunjung.create') }}" class="bg-[#035B73] hover:bg-[#003B4B] text-white px-4 py-2 rounded-md flex items-center transition duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pengunjung
            </a>
        </div>

        <!-- Success Notification -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div>{{ session('success') }}</div>
                </div>
            </div>
        @endif

        <!-- Error Notification -->
        @if(session('error') && isset($pengunjung))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg mx-6 mt-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Tidak dapat menghapus pengunjung
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>{{ session('error') }}</p>
                            <p class="mt-1 font-medium">Peminjaman aktif:</p>
                            <ul class="list-disc pl-5 mt-1">
                                @foreach($pengunjung->peminjaman as $peminjaman)
                                <li>
                                    {{ $peminjaman->buku->judul }} 
                                    ({{ $peminjaman->tanggal_pinjam->format('d/m/Y') }})
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#035B73]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pengunjungs as $pengunjung)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengunjung->nis }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengunjung->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengunjung->kelas }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($pengunjung->jenis_kelamin == 'L')
                                Laki-laki
                            @else
                                Perempuan
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pengunjung->alamat ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex justify-center space-x-2">
                                <!-- Edit Button -->
                                <a href="{{ route('petugas.pengunjung.edit', $pengunjung->id) }}" 
                                   class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-sm flex items-center transition duration-300">
                                   <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                   </svg>
                                   Edit
                                </a>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('petugas.pengunjung.destroy', $pengunjung->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm flex items-center transition duration-300"
                                            onclick="return confirm('Yakin ingin menghapus pengunjung ini?')">
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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data pengunjung
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($pengunjungs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $pengunjungs->firstItem() }}</span> 
                    sampai <span class="font-medium">{{ $pengunjungs->lastItem() }}</span> 
                    dari <span class="font-medium">{{ $pengunjungs->total() }}</span> hasil
                </div>
                <div class="flex space-x-2">
                    @if($pengunjungs->onFirstPage())
                        <span class="px-3 py-1 rounded bg-gray-200 text-gray-500 cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $pengunjungs->previousPageUrl() }}" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Sebelumnya</a>
                    @endif

                    @if($pengunjungs->hasMorePages())
                        <a href="{{ $pengunjungs->nextPageUrl() }}" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Selanjutnya</a>
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