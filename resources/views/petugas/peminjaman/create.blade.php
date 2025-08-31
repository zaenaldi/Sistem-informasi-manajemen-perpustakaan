@extends('layouts.petugas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Tambah Peminjaman</h1>

    <form action="{{ route('petugas.peminjaman.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="buku_id" class="block text-sm font-medium">Judul Buku</label>
            <select name="buku_id" class="w-full border-gray-300 rounded">
                @foreach($bukus as $b)
                    <option value="{{ $b->id }}">{{ $b->judul }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="pengunjung_id" class="block text-sm font-medium">Nama Pengunjung</label>
            <select name="pengunjung_id" class="w-full border-gray-300 rounded">
                @foreach($pengunjungs as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->nis }})</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="w-full border-gray-300 rounded" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" class="w-full border-gray-300 rounded" required>
            </div>
        </div>

        <button type="submit" class="bg-[#035B73] hover:bg-[#003B4B] text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
