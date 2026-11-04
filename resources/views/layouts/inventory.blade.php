<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Manajemen Buku')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6558f5;
            --primary-light: #efedff;
            --sidebar: #17172b;
            --background: #f6f7fb;
            --surface: #ffffff;
            --text: #20213a;
            --muted: #8589a3;
            --border: #ececf3;
            --success: #16a779;
            --danger: #e64e65;
            --warning: #e8a23a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text);
            font-size: 14px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, select, textarea {
            font: inherit;
        }

        .app {
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar);
            color: #fff;
            padding: 28px 18px;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 35px;
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #8175ff, #5143e8);
            border-radius: 13px;
            font-size: 21px;
            font-weight: 800;
            box-shadow: 0 6px 18px #6558f544;
        }

        .brand-name {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .brand-subtitle {
            color: #999ab5;
            font-size: 10px;
            margin-top: 5px;
            letter-spacing: 1.4px;
        }

        .nav-label {
            color: #8586a5;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.6px;
            padding: 0 12px;
            margin: 12px 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            border-radius: 10px;
            color: #b9bad0;
            margin-bottom: 6px;
            transition: .2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
            background: linear-gradient(100deg, #6558f5, #5145d9);
            box-shadow: 0 5px 15px #6558f533;
        }

        .nav-icon {
            width: 22px;
            text-align: center;
            font-size: 17px;
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .sidebar-help {
            padding: 17px;
            border: 1px solid #34344c;
            border-radius: 14px;
            margin-bottom: 18px;
            background: #202039;
        }

        .sidebar-help strong {
            display: block;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .sidebar-help p {
            color: #aaaac1;
            font-size: 11px;
            line-height: 1.7;
            margin: 0;
        }

        .logout-button {
            width: 100%;
            border: 0;
            background: #292941;
            color: #ddddec;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            text-align: left;
        }

        .logout-button:hover {
            background: #3a3048;
            color: #fff;
        }

        /* MAIN */
        .main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            height: 78px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 34px;
            gap: 20px;
        }

        .breadcrumb {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 5px;
        }

        .topbar-title {
            font-size: 17px;
            font-weight: 700;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 13px;
            background: var(--primary-light);
            color: var(--primary);
            display: grid;
            place-items: center;
            font-weight: 800;
        }

        .user-name {
            font-weight: 700;
            font-size: 12px;
        }

        .user-role {
            color: var(--muted);
            font-size: 11px;
            margin-top: 4px;
        }

        .content {
            padding: 32px 34px;
            max-width: 1600px;
            margin: auto;
        }

        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 26px;
        }

        .page-heading h1 {
            font-size: 25px;
            letter-spacing: -.8px;
            margin: 0 0 9px;
        }

        .page-heading p {
            color: var(--muted);
            margin: 0;
            line-height: 1.6;
        }

        /* CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 26px;
        }

        .stat-card {
            background: var(--surface);
            padding: 23px;
            border-radius: 17px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 20px #20213a04;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 22px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
        }

        .stat-icon {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            font-size: 20px;
        }

        .icon-purple { background: #efedff; color: #6558f5; }
        .icon-green { background: #e4f8ef; color: #16a779; }
        .icon-orange { background: #fff3df; color: #df9220; }
        .icon-blue { background: #e5f2ff; color: #3184e6; }

        .stat-number {
            font-size: 29px;
            font-weight: 800;
            letter-spacing: -1px;
            overflow-wrap: anywhere;
        }

        .stat-note {
            color: var(--muted);
            font-size: 11px;
            margin-top: 9px;
        }

        /* PANEL AND TABLE */
        .panel {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 17px;
            overflow: hidden;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px #20213a04;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            padding: 22px 24px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h2 {
            font-size: 15px;
            margin: 0 0 6px;
        }

        .panel-header p {
            color: var(--muted);
            font-size: 12px;
            margin: 0;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        th {
            background: #fafafe;
            color: #888ba2;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        th, td {
            text-align: left;
            padding: 16px 22px;
            border-bottom: 1px solid #f0f0f6;
        }

        td {
            font-size: 12px;
        }

        tbody tr:hover {
            background: #fafaff;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .item-name {
            font-weight: 700;
            font-size: 12px;
        }

        .item-code {
            color: var(--muted);
            font-size: 11px;
            margin-top: 5px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 10px;
            font-weight: 700;
        }

        .badge-purple { background: #efedff; color: #6558f5; }
        .badge-green { background: #e3f8ee; color: #14875f; }
        .badge-orange { background: #fff2dc; color: #a96a0b; }
        .badge-red { background: #ffeaed; color: #d63e56; }

        /* FORMS AND BUTTONS */
        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            border: 0;
            border-radius: 10px;
            padding: 11px 16px;
            cursor: pointer;
            font-weight: 700;
            font-size: 12px;
            transition: .2s;
        }

        .btn-primary {
            color: white;
            background: var(--primary);
            box-shadow: 0 5px 14px #6558f52c;
        }

        .btn-primary:hover {
            background: #5144dc;
            transform: translateY(-1px);
        }

        .btn-light {
            color: #555873;
            background: #f1f1f8;
        }

        .btn-danger {
            background: #ffeaed;
            color: #d63e56;
        }

        .btn-sm {
            padding: 8px 10px;
            font-size: 11px;
        }

        .form-panel {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 17px;
            padding: 27px;
            max-width: 850px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0 20px;
        }

        .form-group {
            margin-bottom: 19px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 12px;
            margin-bottom: 9px;
        }

        .form-control {
            width: 100%;
            border: 1px solid #e3e4ef;
            border-radius: 10px;
            background: #fff;
            padding: 12px 13px;
            color: var(--text);
            outline: none;
            transition: .2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px #6558f51a;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .search-input {
            width: 240px;
            max-width: 100%;
            padding: 11px 13px;
            border: 1px solid #e4e5ef;
            border-radius: 10px;
            outline: none;
        }

        .search-input:focus {
            border-color: var(--primary);
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .alert {
            border-radius: 11px;
            padding: 14px 17px;
            margin-bottom: 20px;
            font-size: 12px;
            line-height: 1.7;
        }

        .alert-success {
            background: #e5f8ef;
            color: #12764f;
            border: 1px solid #c7efdc;
        }

        .alert-danger {
            background: #ffedef;
            color: #b82f45;
            border: 1px solid #ffd5db;
        }

        .empty-state {
            text-align: center;
            padding: 45px 20px;
            color: var(--muted);
        }

        .pagination {
            padding: 20px 24px;
        }

        .pagination nav {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 11px;
            border-radius: 7px;
            background: #f1f1f8;
            margin: 2px;
            font-size: 11px;
        }

        .pagination [aria-current="page"] span {
            background: var(--primary);
            color: #fff;
        }

        .footer {
            color: #9699ae;
            text-align: center;
            padding: 15px 0 5px;
            font-size: 11px;
        }

        @media (max-width: 1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .content {
                padding: 25px 22px;
            }

            .topbar {
                padding: 0 22px;
            }
        }

        @media (max-width: 760px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                padding: 17px;
            }

            .brand {
                padding-bottom: 17px;
            }

            .nav-label,
            .sidebar-help {
                display: none;
            }

            .sidebar nav {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
            }

            .nav-link {
                padding: 10px 12px;
                margin: 0;
                font-size: 12px;
            }

            .sidebar-bottom {
                margin-top: 12px;
            }

            .logout-button {
                width: auto;
                padding: 10px 13px;
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                height: auto;
                min-height: 70px;
                padding: 15px 18px;
            }

            .content {
                padding: 22px 16px;
            }

            .page-heading h1 {
                font-size: 22px;
            }

            .stats-grid {
                gap: 12px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-number {
                font-size: 24px;
            }

            .stat-top {
                margin-bottom: 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .user-name,
            .user-role {
                display: none;
            }
        }

        @media (max-width: 420px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .panel-header {
                padding: 17px;
            }

            .search-input {
                width: 100%;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="app">

    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="brand">
            <div class="brand-logo">B</div>
            <div>
                <div class="brand-name">Manajemen<span style="color:#9b91ff">Buku</span></div>
                <div class="brand-subtitle">SISTEM PERPUSTAKAAN</div>
            </div>
        </a>

        <div class="nav-label">MENU UTAMA</div>

        <nav>
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">▦</span>
                Dashboard
            </a>

            @can('view-books')
                <a href="{{ route('items.index') }}"
                   class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}">
                    <span class="nav-icon">▤</span>
                    Data Buku
                </a>
            @endcan

            @can('manage-categories')
                <a href="{{ route('categories.index') }}"
                   class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <span class="nav-icon">▧</span>
                    Kategori
                </a>
            @endcan

            @can('manage-users')
                <a href="{{ route('users.index') }}"
                   class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span class="nav-icon">👤</span>
                    Kelola Pengguna
                </a>
            @endcan
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-help">
                <strong>Manajemen Buku</strong>
                <p>Kelola data buku dan kategori sesuai hak akses role masing-masing.</p>
            </div>

            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">
                        ↪ &nbsp; Keluar dari aplikasi
                    </button>
                </form>
            @endauth
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <div class="breadcrumb">Manajemen Buku / @yield('breadcrumb', 'Dashboard')</div>
                <div class="topbar-title">@yield('header', 'Dashboard')</div>
            </div>

            @auth
                <div class="user-area">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">
                            {{ auth()->user()->getRoleNames()->first() ?? 'Tanpa Role' }}
                        </div>
                    </div>
                </div>
            @endauth
        </header>

        <section class="content">
            @if (session('success'))
                <div class="alert alert-success">
                    ✓ &nbsp; {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    ⚠ &nbsp; {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa kembali data yang kamu masukkan:</strong>
                    <ul style="margin-bottom:0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            <div class="footer">
                © {{ date('Y') }} Manajemen Buku · Implementasi Breeze &amp; Spatie Permission
            </div>
        </section>
    </main>
</div>

@stack('scripts')
</body>
</html>
