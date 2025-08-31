<aside class="w-64 bg-blue-800 text-white min-h-screen">
    <div class="p-4">
        <h2 class="text-xl font-bold">Menu Admin</h2>
    </div>
    <nav class="mt-6">
        <ul>
            <li class="px-4 py-2 hover:bg-blue-700">
                <a href="{{ route('admin.dashboard') }}" class="block">Dashboard</a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-700">
                <a href="{{ route('petugas.index') }}" class="block">Kelola Petugas</a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-700">
                <a href="{{ route('admin.aktivitas') }}" class="block">Aktivitas</a>
            </li>
        </ul>
    </nav>
</aside>