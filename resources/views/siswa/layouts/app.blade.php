<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIPUSTAKA Siswa')</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f5ef;
            color: #19152f;
        }
        a { text-decoration: none; color: inherit; }
        button, input, select { font: inherit; }
        img, table { max-width: 100%; }

        .layout { min-height: 100vh; }
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 230px;
            padding: 28px 16px;
            background: #19152f;
            color: white;
            overflow-y: auto;
        }

        /* Baris atas sidebar: logo kiri, hamburger kanan */
        .sidebar-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .hamburger-btn { display: none; } /* hanya tampil di HP */

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 8px 44px;
            font: bold 20px Georgia, serif;
        }
        .sidebar-head .brand { margin-bottom: 44px; }
        .brand-mark {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #ff6655;
            font: bold 18px Arial, sans-serif;
        }
        .menu-title {
            margin: 0 10px 12px;
            color: #a49bbd;
            font-size: 10px;
            letter-spacing: 1px;
        }
        .menu { display: grid; gap: 6px; }
        .menu-item {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 12px;
            border-radius: 10px;
            color: #d5d0e6;
            font-size: 13px;
            font-weight: 600;
        }
        .menu-item:hover { background: #292440; }
        .menu-item.active { background: #ff6655; color: white; }
        .menu-icon { width: 20px; text-align: center; }
        .menu-logout { margin-top: 20px; }

        .main { margin-left: 230px; min-width: 0; }
        .topbar {
            min-height: 88px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 30px;
            background: white;
            border-bottom: 1px solid #e8e1d5;
        }
        .topbar > div:first-child { min-width: 0; }
        .topbar h1 {
            margin: 0 0 5px;
            font: 22px Georgia, serif;
            overflow-wrap: anywhere;
        }
        .topbar p { margin: 0; color: #8a829b; font-size: 12px; }
        .avatar {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #eee8ff;
            color: #6848df;
            font-weight: bold;
        }
        .content { padding: 28px 30px; }
        .page-header { margin-bottom: 22px; }
        .page-header h2 {
            margin: 0 0 7px;
            font: 25px Georgia, serif;
        }
        .page-header p { margin: 0; color: #8a829b; font-size: 13px; }

        .stat-row {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }
        .stat-card, .panel, .book-card {
            background: white;
            border: 1px solid #e7e0d4;
            border-radius: 15px;
        }
        .stat-card { padding: 20px; }
        .stat-card small { color: #8a829b; font-size: 12px; }
        .stat-card strong {
            display: block;
            margin-top: 9px;
            font: 30px Georgia, serif;
        }
        .panel { padding: 20px; margin-bottom: 20px; }
        .panel h3 { margin: 0 0 16px; font: 19px Georgia, serif; }
        .muted { color: #8a829b; }
        .small { font-size: 12px; }

        .btn-primary, .btn-dark, .btn-outline {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            padding: 11px 15px;
            border: 0;
            border-radius: 9px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-primary { background: #ff6655; color: white; }
        .btn-primary:hover { background: #f25545; }
        .btn-dark { background: #19152f; color: white; }
        .btn-outline { background: white; border: 1px solid #ddd6cc; }
        .field { display: grid; gap: 7px; margin-bottom: 16px; }
        .field label { font-size: 12px; font-weight: bold; }
        .input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd6cc;
            border-radius: 9px;
            background: #fffdfa;
            outline: none;
        }
        .input:focus { border-color: #7755ef; }

        .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .table { width: 100%; border-collapse: collapse; }
        .table th {
            padding: 13px;
            background: #faf8f4;
            color: #8b8393;
            text-align: left;
            font-size: 10px;
        }
        .table td {
            padding: 14px 13px;
            border-top: 1px solid #eee8df;
            font-size: 12px;
        }
        .badge {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 8px;
            background: #efeae0;
            color: #6f6877;
            font-size: 10px;
            font-weight: bold;
        }
        .badge.pending { background: #fff0d6; color: #9a6500; }
        .badge.success { background: #def4ee; color: #148f7c; }
        .badge.danger { background: #ffe2dd; color: #d74736; }
        .flash { padding: 13px 15px; border-radius: 10px; margin-bottom: 16px; font-size: 13px; }
        .flash.ok { background: #def4ee; color: #0f7c6b; }
        .flash.error { background: #ffe2dd; color: #c2412b; }
        .book-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }
        .book-card { overflow: hidden; }
        .book-cover {
            height: 150px;
            display: grid;
            place-items: center;
            background: #eee8ff;
            color: #6848df;
            font-size: 40px;
        }
        .book-info { padding: 14px; }
        .book-info h4 { margin: 0 0 7px; font-size: 14px; }
        .book-info p { margin: 0 0 12px; color: #8a829b; font-size: 11px; }
        .book-info .btn-primary { width: 100%; }
        .empty { padding: 28px 12px; text-align: center; color: #8a829b; font-size: 13px; }
        .pagination { margin-top: 18px; }

        /* ===== Dashboard: daftar ringkas (Buku Baru, Terlaris, Tersedia) ===== */
        .duo {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 20px;
            align-items: start;
        }
        .duo .panel { margin-bottom: 0; }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }
        .section-title { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .section-title h3 { margin: 0 0 2px; }
        .section-title p { margin: 0; }
        .chip {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 12px;
            font-size: 19px;
        }
        .chip-new { background: #eee8ff; }
        .chip-hot { background: #ffe2dd; }
        .chip-list { background: #def4ee; }
        .see-all { color: #ff6655; font-size: 12px; font-weight: bold; white-space: nowrap; }
        .see-all:hover { text-decoration: underline; }

        .mini-list { display: grid; gap: 10px; }
        .mini-list.two-col { grid-template-columns: repeat(2, minmax(0, 1fr)); }

        .ac-purple { --ac: #7755ef; }
        .ac-teal   { --ac: #14aa99; }
        .ac-1 { --ac: #ff6655; }
        .ac-2 { --ac: #f6a52e; }
        .ac-3 { --ac: #14aa99; }

        .mini-row {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px 10px 16px;
            border: 1px solid #eee8df;
            border-radius: 14px;
            background: #fffdfa;
            transition: transform .2s ease, border-color .2s ease, background .2s ease;
        }
        .mini-row::before {
            content: "";
            position: absolute;
            left: 0;
            top: 12px;
            bottom: 12px;
            width: 4px;
            border-radius: 0 4px 4px 0;
            background: var(--ac, #7755ef);
        }
        .mini-row:hover { transform: translateX(4px); border-color: var(--ac, #7755ef); background: #fff; }

        .mini-cover {
            flex: 0 0 46px;
            width: 46px;
            height: 64px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border-radius: 8px;
            background: #eee8ff;
            color: #6848df;
            font-size: 20px;
            box-shadow: 0 5px 12px -5px rgba(25, 21, 47, .4);
        }
        .mini-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .mini-info { flex: 1; min-width: 0; }
        .mini-info h4 {
            margin: 0 0 3px;
            font-size: 13.5px;
            line-height: 1.3;
            overflow-wrap: anywhere;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .mini-info p {
            margin: 0;
            color: #8a829b;
            font-size: 11.5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .mini-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 7px; }
        .pill { padding: 3px 9px; border-radius: 999px; font-size: 10px; font-weight: bold; }
        .pill-new { background: #eee8ff; color: #6848df; }
        .pill-ok  { background: #def4ee; color: #148f7c; }

        .mini-go { color: #c4bccf; font-size: 22px; line-height: 1; transition: color .2s, transform .2s; }
        .mini-row:hover .mini-go { color: var(--ac, #7755ef); transform: translateX(3px); }

        .rank {
            flex: 0 0 28px;
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: #fff;
            font: bold 13px Georgia, serif;
        }
        .rank-1 { background: #ff6655; }
        .rank-2 { background: #f6a52e; }
        .rank-3 { background: #14aa99; }

        .meter { height: 6px; margin-top: 8px; border-radius: 6px; background: #efeae0; overflow: hidden; }
        .meter-fill { display: block; height: 100%; border-radius: 6px; background: var(--ac, #7755ef); }
        .meter-label { display: block; margin-top: 4px; color: #8a829b; font-size: 11px; font-weight: bold; }

        /* ===== Pagination ===== */
        .pager {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
        .pager-info { margin: 0; color: #8a829b; font-size: 12px; }
        .pager-links { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        .pager-btn {
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd6cc;
            border-radius: 9px;
            background: #fff;
            color: #19152f;
            font-size: 12px;
            font-weight: bold;
            transition: background .15s, border-color .15s;
        }
        a.pager-btn:hover { border-color: #ff6655; color: #ff6655; }
        .pager-btn.active { background: #ff6655; border-color: #ff6655; color: #fff; }
        .pager-btn.disabled { opacity: .45; cursor: default; }
        .pager svg { width: 16px; height: 16px; } /* jaga-jaga bila ada ikon SVG */

        /* ===== Katalog: form pencarian ===== */
        .filter-form { display: flex; gap: 10px; flex-wrap: wrap; }
        .filter-search { flex: 1; min-width: 200px; }
        .filter-select { max-width: 220px; }

        /* ===== Detail buku ===== */
        .detail-grid {
            display: grid;
            grid-template-columns: minmax(150px, 240px) minmax(0, 1fr);
            gap: 24px;
        }
        .detail-img {
            display: block;
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            border-radius: 12px;
            background: #f8f5ef;
        }
        .detail-cover { height: 260px; border-radius: 12px; }
        .detail-title {
            font: 26px Georgia, serif;
            margin: 0 0 10px;
            overflow-wrap: anywhere;
        }
        .detail-facts { display: grid; gap: 10px; font-size: 13px; margin-bottom: 18px; }
        .detail-facts div { overflow-wrap: anywhere; }
        .detail-subtitle { font: 18px Georgia, serif; margin: 0 0 8px; }
        .detail-desc { font-size: 13px; line-height: 1.7; overflow-wrap: anywhere; }
        .loan-form { margin-top: 22px; max-width: 420px; }

        /* ================= TABLET ================= */
        @media (max-width: 1100px) {
            .duo { grid-template-columns: minmax(0, 1fr); }
            .book-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .stat-row { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        /* ================= HP ================= */
        @media (max-width: 760px) {
            /* Sidebar jadi bar di atas, tetap menempel saat di-scroll */
            .sidebar {
                inset: 0 auto auto 0;
                position: sticky;
                z-index: 100;
                width: 100%;
                max-height: 100vh;
                padding: 12px 16px;
            }
            .sidebar-head .brand { margin: 0; }

            /* Tombol hamburger di pojok kanan atas, samping SIPUSTAKA */
            .hamburger-btn {
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 5px;
                width: 42px;
                height: 42px;
                padding: 0 11px;
                flex-shrink: 0;
                border: 1px solid rgba(255, 255, 255, .18);
                border-radius: 10px;
                background: rgba(255, 255, 255, .08);
                cursor: pointer;
            }
            .hamburger-btn span {
                display: block;
                height: 2px;
                border-radius: 2px;
                background: #fff;
                transition: transform .25s ease, opacity .2s ease;
            }
            .hamburger-btn.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
            .hamburger-btn.open span:nth-child(2) { opacity: 0; }
            .hamburger-btn.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

            /* Menu tertutup dulu; saat dibuka tampil 1 kolom */
            .menu-title { display: none; }
            .menu { display: none; }
            .menu.open {
                display: grid;
                grid-template-columns: 1fr;
                gap: 4px;
                margin-top: 12px;
                padding-top: 12px;
                border-top: 1px solid rgba(255, 255, 255, .12);
            }
            .menu-logout { margin-top: 6px; }

            .main { margin-left: 0; }
            .topbar { min-height: 0; padding: 16px; }
            .topbar h1 { font-size: 19px; }
            .content { padding: 18px 16px 28px; }
            .page-header h2 { font-size: 22px; }

            .stat-row { grid-template-columns: 1fr; gap: 12px; }
            .stat-card { padding: 16px 18px; }
            .stat-card strong { font-size: 26px; }

            .panel { padding: 16px; }
            .panel .btn-primary,
            .panel .btn-outline { width: 100%; }

            /* ===== Katalog: form pencarian ===== */
            .filter-form { display: grid; grid-template-columns: minmax(0, 1fr); gap: 10px; }
            .filter-form .filter-search,
            .filter-form .filter-select {
                width: 100%;
                max-width: 100%;
                min-width: 0;
            }
            .filter-form .input,
            .filter-form .btn-dark,
            .filter-form .btn-outline {
                width: 100%;
                min-height: 46px;
            }

            /* ===== Detail buku: gambar di atas, keterangan di bawah ===== */
            .detail-grid { grid-template-columns: minmax(0, 1fr); gap: 18px; }
            .detail-grid .detail-cover { height: 200px; }
            .detail-img { max-height: 260px; }
            .detail-title { font-size: 23px; }
            .loan-form { max-width: none; }
            .loan-form .btn-primary,
            .btn-block-mobile { width: 100%; }

            .mini-list.two-col { grid-template-columns: minmax(0, 1fr); }
            .pager { justify-content: center; }
            .pager-info { width: 100%; text-align: center; }
            .pager-num { display: none; }
            .pager-links { width: 100%; justify-content: space-between; }
            .pager-links .pager-btn { flex: 1; }

            /* tabel digeser ke samping, tidak memecah halaman */
            .table { min-width: 520px; }
        }

        @media (max-width: 480px) {
            .book-grid { grid-template-columns: 1fr; }
            .book-cover { height: 130px; }
        }
    </style>
</head>
<body>
<div class="layout">
    @include('siswa.partials.sidebar')

    <main class="main">
        <header class="topbar">
            <div>
                <h1>@yield('heading', 'Halo, ' . auth()->user()->name)</h1>
                <p>Portal anggota perpustakaan SIPUSTAKA</p>
            </div>
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </header>

        <section class="content">
            @if(session('success'))
                <div class="flash ok">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="flash error">
                    <strong>Periksa kembali data kamu:</strong>
                    <ul style="margin:8px 0 0 18px">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </section>
    </main>
</div>

<script>
    (function () {
        var btn  = document.getElementById('hamburgerBtn');
        var menu = document.getElementById('siswaMenu');
        if (!btn || !menu) return;

        function setOpen(open) {
            menu.classList.toggle('open', open);
            btn.classList.toggle('open', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            btn.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
        }

        btn.addEventListener('click', function () {
            setOpen(!menu.classList.contains('open'));
        });

        // balik ke ukuran desktop -> reset menu
        window.addEventListener('resize', function () {
            if (window.innerWidth > 760) setOpen(false);
        });
    })();
</script>
</body>
</html>