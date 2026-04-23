@extends('layouts.app')
@section('title', 'Tambah Tutorial')
@section('content')
<div class="bg-white rounded-2xl shadow p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold mb-6">Tambah Tutorial</h2>
    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
            <ul>@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ route('tutorials.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
            <input type="text" name="judul" value="{{ old('judul') }}" required
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah</label>
            <select name="kode_matkul" required
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach($matkul as $m)
    <option value="{{ $m['kdmk'] ?? $m['kode'] ?? '' }}" 
        {{ old('kode_matkul') == ($m['kdmk'] ?? '') ? 'selected' : '' }}>
        {{ ($m['kdmk'] ?? '') }} - {{ $m['name'] ?? $m['nama'] ?? 'Unknown' }}
    </option>
@endforeach
            </select>
        </div>
        <div>
        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('tutorials.index') }}"
                class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">Batal</a>
        </div>
    </form>
</div>
@endsection