@extends('layouts.admin')

@section('title', 'Aktivitas Terbaru')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Aktivitas Terbaru</h2>
        </div>

        <div class="p-6">
            @if($aktivitasTerbaru->isEmpty())
                <div class="text-center text-gray-500 py-4">
                    Tidak ada aktivitas terbaru
                </div>
            @else
                <div class="overflow-x-auto">
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