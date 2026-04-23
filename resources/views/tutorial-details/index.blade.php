@extends('layouts.app')
@section('title', 'Detail Tutorial')
@section('content')
<div class="bg-white rounded-2xl shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Detail: {{ $tutorial->judul }}</h2>
            <p class="text-sm text-gray-500">{{ $tutorial->kode_matkul }} - {{ $tutorial->nama_matkul }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('tutorial-details.create', $tutorial->id) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">+ Tambah Detail</a>
            <a href="{{ route('tutorials.index') }}"
                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm">← Kembali</a>
        </div>
    </div>
    <table id="detailTable" class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">#</th>
                <th class="p-2">Text</th>
                <th class="p-2">Gambar</th>
                <th class="p-2">Code</th>
                <th class="p-2">URL</th>
                <th class="p-2">Order</th>
                <th class="p-2">Status</th>
                <th class="p-2">Created At</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
@endsection
@section('scripts')
<script>
$('#detailTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("tutorial-details.data", $tutorial->id) }}',
    columns: [
        { data: 'id' },
        { data: 'text' },
        { data: 'gambar_preview', orderable: false },
        { data: 'code' },
        { data: 'url' },
        { data: 'order' },
        { data: 'status' },
        { data: 'created_at' },
        { data: 'action', orderable: false, searchable: false }
    ]
});
</script>
@endsection