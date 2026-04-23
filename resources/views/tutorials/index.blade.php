@extends('layouts.app')
@section('title', 'Master Tutorial')
@section('content')
<div class="bg-white rounded-2xl shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Master Tutorial</h2>
        <a href="{{ route('tutorials.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">+ Tambah Tutorial</a>
    </div>
    <table id="tutorialTable" class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">#</th>
                <th class="p-2">Judul</th>
                <th class="p-2">Kode MK</th>
                <th class="p-2">Nama MK</th>
                <th class="p-2">URL Presentation</th>
                <th class="p-2">URL Finished</th>
                <th class="p-2">Creator</th>
                <th class="p-2">Created At</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
@endsection
@section('scripts')
<script>
$('#tutorialTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("tutorials.data") }}',
    columns: [
        { data: 'id' },
        { data: 'judul' },
        { data: 'kode_matkul' },
        { data: 'nama_matkul' },
        { data: 'url_presentation' },
        { data: 'url_finished' },
        { data: 'creator_email' },
        { data: 'created_at' },
        { data: 'action', orderable: false, searchable: false }
    ]
});
</script>
@endsection