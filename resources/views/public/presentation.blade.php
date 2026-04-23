<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30"> {{-- Auto refresh setiap 30 detik --}}
    <title>{{ $tutorial->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Header -->
    <div class="bg-blue-700 text-white py-8 px-6 text-center shadow">
        <p class="text-blue-200 text-sm mb-1">{{ $tutorial->kode_matkul }} — {{ $tutorial->nama_matkul }}</p>
        <h1 class="text-3xl font-bold">{{ $tutorial->judul }}</h1>
        <p class="text-blue-200 text-sm mt-2">by {{ $tutorial->creator_email }}</p>
    </div>

    <!-- Auto refresh indicator -->
    <div class="text-center py-2 bg-green-50 border-b border-green-200">
        <span class="text-green-600 text-xs font-medium">🔄 Halaman auto refresh setiap 30 detik</span>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto py-10 px-6 space-y-8">

        @forelse($details as $detail)
        <div class="bg-white rounded-2xl shadow p-6 space-y-4">
            <div class="flex items-center gap-2">
                <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full font-semibold">
                    Step {{ $detail->order }}
                </span>
            </div>

            @if($detail->text)
                <p class="text-gray-700 leading-relaxed">{{ $detail->text }}</p>
            @endif

            @if($detail->gambar)
                <img src="{{ asset('storage/'.$detail->gambar) }}"
                    class="rounded-xl w-full object-cover max-h-96 border">
            @endif

            @if($detail->code)
                <div class="bg-gray-900 text-green-400 rounded-xl p-4 overflow-auto">
                    <pre class="text-sm font-mono whitespace-pre-wrap">{{ $detail->code }}</pre>
                </div>
            @endif

            @if($detail->url)
                <a href="{{ $detail->url }}" target="_blank"
                    class="inline-flex items-center gap-2 text-blue-600 hover:underline text-sm">
                    🔗 {{ $detail->url }}
                </a>
            @endif
        </div>
        @empty
        <div class="text-center py-20 text-gray-400">
            <p class="text-5xl mb-4">📭</p>
            <p class="text-lg">Belum ada konten yang dipublikasikan.</p>
        </div>
        @endforelse

    </div>

    <!-- Footer -->
    <div class="text-center py-6 text-gray-400 text-sm border-t mt-10">
        {{ $tutorial->judul }} &copy; {{ date('Y') }}
    </div>

</body>
</html>