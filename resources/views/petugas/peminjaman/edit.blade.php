@extends('layouts.petugas')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[#003B4B] mb-6">Edit Peminjaman</h1>

    <form action="{{ route('petugas.peminjaman.update', $peminjaman->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pilih Buku -->
                <div>
                    <label for="buku_id" class="block text-gray-700 mb-2">Buku</label>
                    <select name="buku_id" id="buku_id" class="w-full border rounded p-2" required>
                        @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}" 
                            {{ $peminjaman->buku_id == $buku->id ? 'selected' : '' }}>
                            {{ $buku->judul }} (Stok: {{ $buku->tersedia }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Pengunjung -->
                <div>
                    <label for="pengunjung_id" class="block text-gray-700 mb-2">Pengunjung</label>
                    <select name="pengunjung_id" id="pengunjung_id" class="w-full border rounded p-2" required>
                        @foreach($pengunjungs as $pengunjung)
                        <option value="{{ $pengunjung->id }}" 
                            {{ $peminjaman->pengunjung_id == $pengunjung->id ? 'selected' : '' }}>
                            {{ $pengunjung->nama }} ({{ $pengunjung->nis }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Kembali -->
                <div>
                    <label for="tanggal_kembali" class="block text-gray-700 mb-2">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" 
                           value="{{ $peminjaman->tanggal_kembali->format('Y-m-d') }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full border rounded p-2" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('petugas.peminjaman.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded mr-2">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-[#035B73] hover:bg-[#003B4B] text-white px-4 py-2 rounded">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection