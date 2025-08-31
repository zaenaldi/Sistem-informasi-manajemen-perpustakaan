@extends('layouts.petugas')

@section('title', 'Laporan')
@section('submenu-active', true)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Filter Form -->
    <form method="GET" action="{{ route('petugas.laporan') }}" class="mb-6">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <!-- Bulan -->
            <div>
                <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                <select name="bulan" id="bulan" class="mt-1 block w-48 border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#035B73] focus:border-[#035B73]">
                    <option value="">-- Semua Bulan --</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ \DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Tahun -->
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                <select name="tahun" id="tahun" class="mt-1 block w-48 border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#035B73] focus:border-[#035B73]">
                    <option value="">-- Semua Tahun --</option>
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <!-- Tombol Tampilkan -->
            <div class="md:pt-6">
                <button type="submit" class="mt-6 bg-[#035B73] hover:bg-[#024256] text-white px-4 py-2 rounded-lg transition duration-200">
                    Tampilkan
                </button>
            </div>
        </div>
    </form>

    <!-- Tabel Laporan -->
    <div class="bg-white rounded-lg  overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#035B73] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Judul Buku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Pengunjung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($peminjaman as $item)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $item->buku->judul }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $item->pengunjung->nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ date('d/m/Y', strtotime($item->tanggal_pinjam)) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ date('d/m/Y', strtotime($item->tanggal_kembali)) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($item->status == 'Dipinjam') bg-yellow-100 text-yellow-800 
                                    @elseif($item->status == 'Dikembalikan') bg-green-100 text-green-800 
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bawah Tabel: Tombol Cetak & Export + Pagination -->
        <div class="flex flex-col md:flex-row justify-between items-center px-4 py-4 bg-gray-50 border-t border-gray-200">
            <!-- Tombol Cetak & Export -->
            <div class="flex gap-2 mb-4 md:mb-0">
                <a href="{{ route('petugas.laporan.cetak', request()->query()) }}" target="_blank"
                   class="text-white hover:bg-[#003B4B] bg-[#035B73] px-4 py-2 rounded-lg text-center transition duration-200">
                    Cetak PDF
                </a>
                <a href="{{ route('petugas.laporan.export', request()->query()) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-center transition duration-200">
                    Export Excel
                </a>
            </div>

            <!-- Pagination -->
            <div>
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
