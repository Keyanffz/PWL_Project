@extends('layouts.app')
@section('title', 'Edit Tutorial')
@section('content')
<div class="bg-white rounded-2xl shadow p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold mb-6">Edit Tutorial</h2>
    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
            <ul>@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ route('tutorials.update', $tutorial->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
            <input type="text" name="judul" value="{{ old('judul', $tutorial->judul) }}" required
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah</label>
            <select name="kode_matkul" required
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
                @foreach($matkul as $m)
                    <option value="{{ $m['kdmk'] ?? '' }}"
    {{ old('kode_matkul', $tutorial->kode_matkul) == ($m['kdmk'] ?? '') ? 'selected' : '' }}>
    {{ $m['kdmk'] ?? '' }} - {{ $m['name'] ?? $m['nama'] ?? 'Unknown' }}
</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">URL Presentation</label>
            <input type="url" name="url_presentation" value="{{ old('url_presentation', $tutorial->url_presentation) }}" required
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">URL Finished</label>
            <input type="url" name="url_finished" value="{{ old('url_finished', $tutorial->url_finished) }}" required
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg">Update</button>
            <a href="{{ route('tutorials.index') }}"
                class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">Batal</a>
        </div>
    </form>
</div>
@endsection