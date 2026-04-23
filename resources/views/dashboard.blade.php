@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div style="margin-bottom:24px;">
    <h1 style="font-size:24px;font-weight:800;color:#0f172a;">👋 Selamat Datang!</h1>
    <p style="color:#64748b;font-size:14px;margin-top:4px;">Kelola tutorial kamu dari sini.</p>
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">
    <!-- Card 1 -->
    <div style="background:linear-gradient(135deg,#2563eb,#1d4ed8);color:white;padding:24px;border-radius:16px;">
        <div style="font-size:32px;margin-bottom:12px;">📚</div>
        <div style="font-size:28px;font-weight:800;">{{ \App\Models\Tutorial::count() }}</div>
        <div style="font-size:13px;opacity:0.8;margin-top:4px;">Total Tutorial</div>
    </div>
    <!-- Card 2 -->
    <div style="background:linear-gradient(135deg,#059669,#047857);color:white;padding:24px;border-radius:16px;">
        <div style="font-size:32px;margin-bottom:12px;">✅</div>
        <div style="font-size:28px;font-weight:800;">{{ \App\Models\TutorialDetail::where('status','show')->count() }}</div>
        <div style="font-size:13px;opacity:0.8;margin-top:4px;">Detail Published</div>
    </div>
    <!-- Card 3 -->
    <div style="background:linear-gradient(135deg,#d97706,#b45309);color:white;padding:24px;border-radius:16px;">
        <div style="font-size:32px;margin-bottom:12px;">🙈</div>
        <div style="font-size:28px;font-weight:800;">{{ \App\Models\TutorialDetail::where('status','hide')->count() }}</div>
        <div style="font-size:13px;opacity:0.8;margin-top:4px;">Detail Hidden</div>
    </div>
</div>

<!-- Quick Access -->
<div style="background:white;border-radius:16px;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,0.08);">
    <h2 style="font-size:16px;font-weight:700;color:#0f172a;margin-bottom:16px;">⚡ Quick Access</h2>
    <a href="{{ route('tutorials.index') }}"
        style="display:inline-flex;align-items:center;gap:8px;background:#2563eb;color:white;padding:10px 20px;border-radius:10px;text-decoration:none;font-size:14px;font-weight:600;">
        📖 Kelola Master Tutorial →
    </a>
</div>

@endsection