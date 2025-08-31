{{-- resources/views/components/layouts/welcome-layout.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPUSKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header/Navbar -->
    <nav class="bg-teal-800 text-white py-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo-kemdikbud.png') }}" alt="Logo" class="h-8">
                <h1 class="text-2xl font-bold">SIMPUSKU</h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('register') }}" class="text-white hover:underline">Register</a>
                <a href="{{ route('login') }}">
                    <button class="bg-white text-teal-800 px-4 py-1 rounded-md font-semibold hover:bg-gray-100">Login</button>
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-sm py-6">
        <div class="container mx-auto text-center">
            <p>© {{ date('Y') }} Simpusku</p>
        </div>
    </footer>
</body>
</html>
