@extends('layouts.admin')

@section('title', 'Tambah Petugas')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="mb-4 text-xl font-semibold text-gray-800 text-center">Tambah Petugas Baru</div>
                </div>

                <div class="card-body mt-4">
                    <form method="POST" action="{{ route('admin.petugas.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"id="name" name="name" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                            <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" required>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                            <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="flex items-center justify-between">
                        <button type="submit" class="bg-[#035B73] hover:bg-[#003B4B] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
                        <a href="{{ route('admin.petugas.index') }}" class="inline-block align-baseline font-bold text-sm text-bg-[#035B73] hover:text-[#003B4B]">Kembali</a>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection
