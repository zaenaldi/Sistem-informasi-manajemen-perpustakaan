@extends('layouts.petugas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-center items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 text-center">Tambah Buku Baru</h1>
        </div>

        {{-- Notifikasi Error Global --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Buku -->
                <div>
                    <label for="kode_buku" class="block mb-2 font-medium text-gray-700">Kode Buku</label>
                    <input type="text" name="kode_buku" id="kode_buku" 
                           value="{{ old('kode_buku') }}"
                           class="w-full border rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 
                           @error('kode_buku') border-red-500 @else border-gray-300 @enderror" required>
                    @error('kode_buku')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Judul -->
                <div>
                    <label for="judul" class="block mb-2 font-medium text-gray-700">Judul Buku</label>
                    <input type="text" name="judul" id="judul" 
                           value="{{ old('judul') }}"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategoriSelect" class="block mb-2 font-medium text-gray-700">Kategori</label>
                    <select name="kategori_id" id="kategoriSelect" 
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategories as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kategori Baru -->
                <div>
                    <label for="kategoriBaru" class="block mb-2 font-medium text-gray-700">Atau Tambah Kategori Baru</label>
                    <input type="text" name="kategori_baru" id="kategoriBaru" placeholder="Misal: Biografi"
                           value="{{ old('kategori_baru') }}"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Penulis -->
                <div>
                    <label for="penulis" class="block mb-2 font-medium text-gray-700">Penulis</label>
                    <input type="text" name="penulis" id="penulis" 
                           value="{{ old('penulis') }}"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Penerbit -->
                <div>
                    <label for="penerbit" class="block mb-2 font-medium text-gray-700">Penerbit</label>
                    <input type="text" name="penerbit" id="penerbit" 
                           value="{{ old('penerbit') }}"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Tahun Terbit -->
                <div>
                    <label for="tahun_terbit" class="block mb-2 font-medium text-gray-700">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" 
                           value="{{ old('tahun_terbit') }}"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block mb-2 font-medium text-gray-700">Jumlah Stok</label>
                    <input type="number" name="jumlah" id="jumlah" min="1" 
                           value="{{ old('jumlah') }}"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Cover Buku -->
                <div class="md:col-span-2">
                    <label class="block mb-2 font-medium text-gray-700">Cover Buku</label>
                    
                    <!-- Preview Image -->
                    <div class="mb-4 hidden" id="coverPreviewContainer">
                        <img id="coverPreview" class="h-48 rounded-lg border border-gray-300 object-cover">
                        <button type="button" id="removeCover" 
                                class="mt-2 text-red-600 hover:text-red-800 text-sm flex items-center">
                            <i class="fas fa-times mr-1"></i> Hapus Gambar
                        </button>
                    </div>
                    
                    <div class="flex items-center">
                        <label for="cover" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg border border-gray-300">
                            <i class="fas fa-upload mr-2"></i> Pilih File
                            <input type="file" id="cover" name="cover" class="hidden" accept="image/*">
                        </label>
                        <span class="ml-3 text-sm text-gray-500" id="fileName">Belum ada file dipilih</span>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block mb-2 font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('petugas.buku.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script untuk Preview Cover -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const coverInput = document.getElementById('cover');
        const coverPreview = document.getElementById('coverPreview');
        const coverPreviewContainer = document.getElementById('coverPreviewContainer');
        const fileName = document.getElementById('fileName');
        const removeCover = document.getElementById('removeCover');

        coverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    coverPreview.src = event.target.result;
                    coverPreviewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
                fileName.textContent = file.name;
            }
        });

        removeCover.addEventListener('click', function() {
            coverInput.value = '';
            coverPreviewContainer.classList.add('hidden');
            fileName.textContent = 'Belum ada file dipilih';
        });
    });
</script>

<style>
    #coverPreview {
        max-width: 100%;
        height: auto;
    }
</style>
@endsection
