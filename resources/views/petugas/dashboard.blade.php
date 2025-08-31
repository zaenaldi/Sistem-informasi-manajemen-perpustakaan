@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="container mx-auto px-4 py-8">    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Buku</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $totalBuku }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Pengunjung</h3>
            <p class="text-3xl font-bold text-green-600">{{ $totalPengunjung }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Peminjaman Hari Ini</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $peminjamanHariIni }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Peminjaman Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">No</th>
                        <th class="py-2 px-4 border-b">Judul Buku</th>
                        <th class="py-2 px-4 border-b">Pengunjung</th>
                        <th class="py-2 px-4 border-b">Tanggal Pinjam</th>
                        <th class="py-2 px-4 border-b">Tanggal Kembali</th>
                        <th class="py-2 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamanTerbaru as $item)
                    <tr>
                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->buku->judul }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->pengunjung->nama }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->tanggal_kembali->format('d/m/Y') }}</td>
                        <td class="py-2 px-4 border-b">
                            <span class="px-2 py-1 rounded-full text-xs 
                                {{ $item->status == 'Dipinjam' ? 'bg-blue-100 text-blue-800' : 
                                   ($item->status == 'Dikembalikan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection