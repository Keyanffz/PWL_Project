<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 13px; color: #1a1a1a; }

        .header {
            background: #1d4ed8;
            color: white;
            padding: 24px;
            text-align: center;
            margin-bottom: 24px;
        }
        .header h1 { font-size: 22px; font-weight: bold; margin-bottom: 6px; }
        .header p  { font-size: 12px; opacity: 0.8; }

        .step {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .step-badge {
            background: #1d4ed8;
            color: white;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 10px;
        }
        .step-status-hide {
            background: #f59e0b;
        }
        .text-content { line-height: 1.7; margin-bottom: 10px; }
        .code-block {
            background: #1e293b;
            color: #86efac;
            padding: 12px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 11px;
            white-space: pre-wrap;
            word-break: break-all;
            margin-bottom: 10px;
        }
        .url-link { color: #2563eb; font-size: 12px; }
        .gambar { max-width: 100%; border-radius: 6px; margin-bottom: 10px; }
        .footer { text-align: center; margin-top: 30px; font-size: 11px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <p>{{ $tutorial->kode_matkul }} — {{ $tutorial->nama_matkul }}</p>
        <h1>{{ $tutorial->judul }}</h1>
        <p>by {{ $tutorial->creator_email }} | {{ $tutorial->created_at->format('d M Y') }}</p>
    </div>

    @foreach($details as $detail)
    <div class="step">
        <span class="step-badge {{ $detail->status == 'hide' ? 'step-status-hide' : '' }}">
            Step {{ $detail->order }} — {{ strtoupper($detail->status) }}
        </span>

        @if($detail->text)
            <p class="text-content">{{ $detail->text }}</p>
        @endif

        @if($detail->gambar)
            <img src="{{ storage_path('app/public/'.$detail->gambar) }}" class="gambar">
        @endif

        @if($detail->code)
            <div class="code-block">{{ $detail->code }}</div>
        @endif

        @if($detail->url)
            <p>🔗 <span class="url-link">{{ $detail->url }}</span></p>
        @endif
    </div>
    @endforeach

    <div class="footer">
        {{ $tutorial->judul }} — Generated {{ date('d M Y H:i') }}
    </div>
</body>
</html>