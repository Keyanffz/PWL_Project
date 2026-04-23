@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Welcome Card -->
    <div class="bg-white rounded-2xl shadow p-6 col-span-2">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">👋 Selamat Datang!</h1>
        <p class="text-gray-500">Login sebagai: <strong>{{ session('email') }}</strong></p>
    </div>

    <!-- Card Master Tutorial -->
    <a href="{{ route('tutorials.index') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow p-6 flex items-center gap-4 transition">
        <div class="text-5xl">📚</div>
        <div>
            <h2 class="text-xl font-bold">Master Tutorial</h2>
            <p class="text-blue-100 text-sm">Kelola data tutorial (CRUD)</p>
        </div>
    </a>

    <!-- Card Info Token -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-lg font-bold text-gray-700 mb-2">🔑 Refresh Token</h2>
        <p class="text-xs break-all text-gray-500 font-mono bg-gray-50 p-3 rounded-lg">
            {{ session('refresh_token') }}
        </p>
    </div>

</div>
@endsection