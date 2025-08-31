@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <!-- Notifikasi -->
        @if(session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                {{ session('status') }}
            </div>
        @endif

        <!-- Profil Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 bg-[#035B73] text-white">
                <h2 class="text-xl font-semibold">Edit Profil Administrator</h2>
                <p class="text-sm opacity-75 mt-1">Halaman pengelolaan profil khusus admin</p>
            </div>

            <!-- Form Edit Profil -->
            <div class="p-6">
                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-span-1">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
            <div class="px-6 py-4 bg-[#035B73] text-white">
                <h2 class="text-xl font-semibold">Ganti Password</h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('admin.profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <!-- Password Sekarang -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Sekarang</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Baru -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                            <input type="password" id="password" name="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hapus Akun Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
            <div class="px-6 py-4 bg-red-600 text-white">
                <h2 class="text-xl font-semibold">Hapus Akun</h2>
            </div>

            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">Setelah akun dihapus, semua data akan terhapus permanen.</p>
                
                <form method="POST" action="{{ route('admin.profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="mb-4">
                        <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" id="delete_password" name="password" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('password', 'userDeletion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus akun admin?')">
                        Hapus Akun Admin
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection