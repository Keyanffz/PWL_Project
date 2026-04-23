@extends('layouts.app')
@section('title', 'Detail Tutorial')
@section('content')

<div style="background:white;border-radius:16px;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,0.08);">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <div>
            <h2 style="font-size:20px;font-weight:800;color:#0f172a;">Detail: {{ $tutorial->judul }}</h2>
            <p style="color:#64748b;font-size:13px;margin-top:2px;">{{ $tutorial->kode_matkul }} — {{ $tutorial->nama_matkul }}</p>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('tutorial-details.create', $tutorial->id) }}"
                style="background:#2563eb;color:white;padding:9px 16px;border-radius:9px;text-decoration:none;font-size:13px;font-weight:600;">
                ＋ Tambah Detail
            </a>
            <a href="{{ route('tutorials.index') }}"
                style="background:#e2e8f0;color:#475569;padding:9px 16px;border-radius:9px;text-decoration:none;font-size:13px;font-weight:600;">
                ← Kembali
            </a>
        </div>
    </div>

    <table id="detailTable" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Text</th>
                <th>Gambar</th>
                <th>Code</th>
                <th>URL</th>
                <th>Order</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Aksi</th>
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
        { data: 'id', width: '40px' },
        { data: 'text', render: d => d ? `<span style="font-size:12px;">${d.substring(0,50)}${d.length>50?'...':''}</span>` : '-' },
        { data: 'gambar_preview', orderable: false },
        { data: 'code', render: d => d ? `<code style="font-size:11px;background:#f1f5f9;padding:2px 6px;border-radius:4px;">${d.substring(0,30)}...</code>` : '-' },
        { data: 'url', render: d => d ? `<a href="${d}" target="_blank" style="color:#2563eb;font-size:12px;">🔗 Link</a>` : '-' },
        { data: 'order', width: '60px' },
        { data: 'status', render: d => d === 'show'
            ? `<span style="background:#dcfce7;color:#166534;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">Show</span>`
            : `<span style="background:#fef9c3;color:#854d0e;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">Hide</span>`
        },
        { data: 'created_at', render: d => `<span style="font-size:12px;">${d}</span>` },
        { data: 'action', orderable: false, searchable: false }
    ]
});
</script>
@endsection