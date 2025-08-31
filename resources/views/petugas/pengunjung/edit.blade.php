@extends('layouts.petugas')

@section('title', 'Edit Data Pengunjung')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-6 text-center">Edit Data Pengunjung</h2>
    
    <form action="{{ route('petugas.pengunjung.update', $pengunjung->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- NIS Field -->
            <div class="mb-4">
                <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                <input type="text" name="nis" id="nis" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('nis', $pengunjung->nis) }}" required maxlength="20">
                @error('nis')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Field -->
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('nama', $pengunjung->nama) }}" required>
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kelas Field -->
            <div class="mb-4">
                <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <input type="text" name="kelas" id="kelas" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('kelas', $pengunjung->kelas) }}" required>
                @error('kelas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kelamin Field -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="jenis_kelamin" value="L" 
                               class="form-radio h-4 w-4 text-blue-600" 
                               {{ old('jenis_kelamin', $pengunjung->jenis_kelamin) == 'L' ? 'checked' : '' }} required>
                        <span class="ml-2">Laki-laki</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="jenis_kelamin" value="P" 
                               class="form-radio h-4 w-4 text-blue-600"
                               {{ old('jenis_kelamin', $pengunjung->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                        <span class="ml-2">Perempuan</span>
                    </label>
                </div>
                @error('jenis_kelamin')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat Field -->
            <div class="mb-4 md:col-span-2">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat', $pengunjung->alamat) }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6 space-x-3">
            <a href="{{ route('petugas.pengunjung.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Update
            </button>
        </div>
    </form>
</div>
@endsection