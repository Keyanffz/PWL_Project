<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tutorial App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .dt-container { font-size: 13px; }
        table.dataTable thead th { background: #f8fafc; color: #475569; font-weight: 600; border-bottom: 2px solid #e2e8f0 !important; padding: 12px 16px; }
        table.dataTable tbody td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        table.dataTable tbody tr:hover { background: #f8fafc; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #2563eb !important; color: white !important; border-radius: 6px; border: none !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #eff6ff !important; color: #2563eb !important; border-radius: 6px; border: none !important; }
        .dataTables_wrapper .dataTables_filter input { border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 12px; outline: none; }
        .dataTables_wrapper .dataTables_length select { border: 1px solid #e2e8f0; border-radius: 8px; padding: 4px 8px; }
    </style>
</head>
<body style="background:#f1f5f9; min-height:100vh;">

    <!-- Sidebar + Content Layout -->
    <div style="display:flex; min-height:100vh;">

        <!-- Sidebar -->
        <aside style="width:240px; background:linear-gradient(160deg,#1e3a8a,#1d4ed8); color:white; padding:0; display:flex; flex-direction:column; position:fixed; height:100vh; z-index:50;">
            <!-- Logo -->
            <div style="padding:24px 20px; border-bottom:1px solid rgba(255,255,255,0.1);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="width:36px;height:36px;background:white;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <span style="font-size:18px;">📚</span>
                    </div>
                    <div>
                        <div style="font-weight:800;font-size:15px;">TutorialApp</div>
                        <div style="font-size:11px;opacity:0.6;">Management System</div>
                    </div>
                </div>
            </div>

            <!-- Nav -->
            <nav style="padding:16px 12px; flex:1;">
                <div style="font-size:10px;font-weight:700;opacity:0.4;letter-spacing:1px;padding:0 8px;margin-bottom:8px;">MENU</div>
                <a href="{{ route('dashboard') }}"
                    style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;color:white;text-decoration:none;font-size:14px;font-weight:500;margin-bottom:4px;
                    {{ request()->routeIs('dashboard') ? 'background:rgba(255,255,255,0.2)' : 'opacity:0.7' }}">
                    <span>🏠</span> Dashboard
                </a>
                <a href="{{ route('tutorials.index') }}"
                    style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;color:white;text-decoration:none;font-size:14px;font-weight:500;margin-bottom:4px;
                    {{ request()->routeIs('tutorials.*') ? 'background:rgba(255,255,255,0.2)' : 'opacity:0.7' }}">
                    <span>📖</span> Master Tutorial
                </a>
            </nav>

            <!-- User Info -->
            <div style="padding:16px 12px;border-top:1px solid rgba(255,255,255,0.1);">
                <div style="background:rgba(255,255,255,0.1);border-radius:10px;padding:12px;">
                    <div style="font-size:11px;opacity:0.6;margin-bottom:4px;">Login sebagai</div>
                    <div style="font-size:12px;font-weight:600;word-break:break-all;">{{ session('email') }}</div>
                    <form action="{{ route('logout') }}" method="POST" style="margin-top:10px;">
                        @csrf
                        <button style="width:100%;background:rgba(239,68,68,0.8);color:white;border:none;padding:8px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main style="margin-left:240px; flex:1; padding:28px;">
            @if(session('success'))
                <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:8px;">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    @yield('scripts')
</body>
</html>