@extends('layouts.app')
@section('title', 'Tambah Detail Tutorial')
@section('content')
<div class="bg-white rounded-2xl shadow p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold mb-6">Tambah Detail: {{ $tutorial->judul }}</h2>
    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
            <ul>@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ route('tutorial-details.store', $tutorial->id) }}" method="POST"
        enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Text</label>
            <textarea name="text" rows="4"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">{{ old('text') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
            <input type="file" name="gambar" accept="image/*"
                class="w-full border rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
            <textarea name="code" rows="4"
                class="w-full border rounded-lg px-4 py-2 font-mono focus:ring-2 focus:ring-blue-400 outline-none">{{ old('code') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
            <input type="url" name="url" value="{{ old('url') }}"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                <input type="number" name="order" value="{{ old('order', 1) }}" required
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" required
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
                    <option value="show" {{ old('status') == 'show' ? 'selected' : '' }}>Show</option>
                    <option value="hide" {{ old('status') == 'hide' ? 'selected' : '' }}>Hide</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('tutorial-details.index', $tutorial->id) }}"
                class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">Batal</a>
        </div>
    </form>
</div>
@endsection