<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Simpusku</title>

    <!-- Fonts & Tailwind -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-white text-gray-800">

    <!-- Navbar -->
<nav class="bg-[#003B4B] text-white fixed top-0 w-full z-50 shadow-md">
    <div class="px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logosekolah.png') }}" alt="Logo" class="h-8 w-auto">
            <span class="text-xl font-bold">SIMPUSKU</span>
        </div>
        <div class="space-x-4">
            @guest
                <a href="{{ route('login') }}" class="bg-white text-[#003B4B] px-3 py-1 rounded hover:bg-gray-100">Login</a>
                <!-- <a href="{{ route('register') }}" class="hover:underline">Register</a> -->
            @else
                <span>{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>

    <!-- Main Content -->
    <main class="flex-grow px-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 mt-auto text-sm text-white bg-black">
        &copy; 2025 Sistem Informasi Manajemen Sekolah Dasar Negeri 02 Kuta
    </footer>

</body>
</html>
