<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tutorial App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center shadow">
        <div class="flex gap-6 font-semibold">
            <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
            <a href="{{ route('tutorials.index') }}" class="hover:underline">Master Tutorial</a>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm">{{ session('email') }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    @yield('scripts')
</body>
</html>