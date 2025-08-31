<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPUSKU - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-[#035B73] text-white flex flex-col fixed h-full z-10">
                <!-- Profil Petugas -->
                <div class="px-6 py-4 bg-[#003B4B]">
                    <div class="p-6">
                        <div class="grid place-items-center gap-2">
                            <!-- Logo -->
                            <img src="{{ asset('images/logosekolah.png') }}" alt="Logo SIMPUSKU" class="h-12 w-12">
                            <!-- Teks -->
                            <h1 class="text-2xl font-bold">SIMPUSKU</h1>
                        </div>
                    </div>

                    <!-- Info Profil + Tombol Edit -->
                    <div class="flex items-center justify-between mt-2">
                        <!-- Identitas User -->
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-[#035B73]">
                                <span class="text-lg font-medium leading-none text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </span>
                            <div>
                                <p class="font-medium">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-300">Petugas Perpustakaan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Petugas -->
                <div class="px-6 py-4 border-t border-[#003B4B]">
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-[#035B73] rounded flex items-center 
                                      @if(request()->routeIs('admin.dashboard*')) bg-[#035B73] active-menu @else bg-[#003B4B] @endif">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.petugas.index') }}" class="block px-4 py-2 hover:bg-[#035B73] rounded flex items-center 
                                      @if(request()->routeIs('admin.petugas.index*')) bg-[#035B73] active-menu @else bg-[#003B4B] @endif">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Kelola Petugas
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.aktivitas') }}" class="block px-4 py-2 hover:bg-[#035B73] rounded flex items-center 
                                      @if(request()->routeIs('admin.aktivitas*')) bg-[#035B73] active-menu @else bg-[#003B4B] @endif">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Aktivitas
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.profile.edit') }}"class="block px-4 py-2 hover:bg-[#035B73] rounded flex items-center 
                                      @if(request()->routeIs('admin.profile.edit*')) bg-[#035B73] active-menu @else bg-[#003B4B] @endif">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 
                                        2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 
                                        00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 
                                        00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 
                                        00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 
                                        00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 
                                        001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 
                                        2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="ml-1">Edit Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>
            
            <!-- Logout -->
            <div class="mt-auto p-4 bg-[#003B4B]">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 text-white hover:bg-[#035B73] bg-[#003B4B] rounded">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col ml-64 h-screen overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-lg fixed top-0 left-64 right-0 z-50">
                <div class="flex justify-between items-center px-6 py-4">
                    <h2 class="text-xl font-semibold text-[#003B4B] ">@yield('title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">
                        <!-- Notifikasi Bell -->
                        <div class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto scroll-content pt-20 p-6 bg-gray-50">
                <!-- Notifikasi Session -->
                @if(session('status'))
                    <div class="mb-4 px-4 py-3 rounded relative bg-green-100 border border-green-400 text-green-700">
                        {{ session('status') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 px-4 py-3 rounded relative bg-red-100 border border-red-400 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
