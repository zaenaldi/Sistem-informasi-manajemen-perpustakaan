@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Petugas -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Petugas</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalPetugas }}</p>
                </div>
            </div>
        </div>
        
        <!-- Total Pengunjung -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Pengunjung</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $totalPengunjung }}</p>
                </div>
            </div>
        </div>
        
        <!-- Total Buku -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Buku</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalBuku }}</p>
                </div>
            </div>
        </div>
        
        <!-- Total Peminjaman -->
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Peminjaman</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $totalPeminjaman }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru (Versi Tabel) -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Aktivitas Terbaru</h2>
        </div>

        <div class="p-6">
            @if($aktivitasTerbaru->isEmpty())
                <div class="text-center text-gray-500 py-4">
                    Tidak ada aktivitas terbaru
                </div>
            @else
                <div class="mt-4 bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-[#035B73] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Pengunjung</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Petugas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Waktu Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($aktivitasTerbaru as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($item->buku->cover ?? false)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ asset('storage/'.$item->buku->cover) }}" alt="{{ $item->buku->judul ?? '' }}">
                                        </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->buku->judul ?? '-' }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->buku->penulis ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $item->pengunjung->nama ?? '-' }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->pengunjung->nis ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->petugas->name ?? 'System' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($item->status == 'Dipinjam') bg-blue-100 text-blue-800
                                        @elseif($item->status == 'Dikembalikan') bg-green-100 text-green-800
                                        @elseif($item->status == 'Terlambat') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $item->status }}
                                        @if($item->denda > 0)
                                        (Rp {{ number_format($item->denda, 0, ',', '.') }})
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $aktivitasTerbaru->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection