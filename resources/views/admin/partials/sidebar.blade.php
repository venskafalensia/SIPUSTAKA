{{-- Pakai: @include('admin.partials.sidebar', ['active' => 'kategori']) --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="adminSidebar">
    <div class="brand">
        <div class="brand-logo"><span></span><span></span><span></span><span></span></div>
        <strong>SIPUSTAKA</strong>
        <button type="button" class="sidebar-close" id="sidebarClose" aria-label="Tutup menu">&times;</button>
    </div>

    <div class="menu-title">Menu Utama</div>
    <nav class="menu">
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ $active === 'dashboard' ? 'active' : '' }}">
            <span class="menu-icon">⌂</span><span>Dashboard</span>
        </a>
        <a href="{{ route('admin.books.index') }}" class="menu-item {{ $active === 'books' ? 'active' : '' }}">
            <span class="menu-icon">▣</span><span>Data Buku</span>
        </a>
        <a href="{{ route('admin.kategori.index') }}" class="menu-item {{ $active === 'kategori' ? 'active' : '' }}">
            <span class="menu-icon">◇</span><span>Kategori</span>
        </a>
        <a href="{{ route('admin.anggota.index') }}" class="menu-item {{ $active === 'anggota' ? 'active' : '' }}">
            <span class="menu-icon">♙</span><span>Anggota</span>
        </a>
    </nav>

    <div class="menu-title" style="margin-top:25px;">Transaksi</div>
    <nav class="menu">
        <a href="{{ route('admin.peminjaman.index') }}" class="menu-item {{ $active === 'peminjaman' ? 'active' : '' }}">
            <span class="menu-icon">⇄</span><span>Peminjaman</span>
        </a>
        <a href="{{ route('admin.pengembalian.index') }}" class="menu-item {{ $active === 'pengembalian' ? 'active' : '' }}">
            <span class="menu-icon">↻</span><span>Pengembalian</span>
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="menu-item {{ $active === 'laporan' ? 'active' : '' }}">
            <span class="menu-icon">▥</span><span>Laporan</span>
        </a>
    </nav>

    <div style="margin-top:30px">
        <div style="height:1px;background:#39334f;margin:0 0 18px"></div>

        <a href="{{ route('admin.profil.index') }}" class="menu-item {{ $active === 'profil' ? 'active' : '' }}">
            <span class="menu-icon">⚙</span><span>Profil</span>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="menu-item" style="width:100%;border:none;background:transparent;cursor:pointer;text-align:left;margin-top:5px">
                <span class="menu-icon">↪</span><span>Keluar</span>
            </button>
        </form>
    </div>
</aside>

{{-- Tombol hamburger: dipindah lewat JS ke pojok kanan atas topbar --}}
<button type="button" class="menu-toggle" id="menuToggle"
        aria-label="Buka menu" aria-expanded="false" aria-controls="adminSidebar">
    <span></span><span></span><span></span>
</button>

@once
<style>
    /* ===== Hamburger admin: disembunyikan di desktop ===== */
    .menu-toggle,
    .sidebar-close { display: none; }
    .sidebar-overlay { display: none; }

    @media (max-width: 800px) {

        body.menu-open { overflow: hidden; }

        /* --- Sidebar jadi menu geser, tulisan menu terlihat --- */
        .sidebar {
            width: 270px !important;
            max-width: 82vw;
            z-index: 1001;
            transform: translateX(-100%);
            transition: transform .28s ease;
        }
        .sidebar.open {
            transform: translateX(0) !important;
            box-shadow: 8px 0 30px rgba(0, 0, 0, .3);
        }

        .sidebar-overlay {
            display: block;
            position: fixed;
            inset: 0;
            z-index: 1000;
            background: rgba(25, 21, 47, .55);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity .25s ease, visibility .25s ease;
        }
        .sidebar-overlay.show { opacity: 1; visibility: visible; pointer-events: auto; }

        .sidebar .brand { margin-bottom: 32px; }

        .sidebar-close {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            margin-left: auto;
            border: 1px solid #39334f;
            border-radius: 9px;
            background: transparent;
            color: #d5d0e6;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
        }

        /* --- Tombol hamburger --- */
        .menu-toggle {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            width: 40px;
            height: 40px;
            padding: 0 10px;
            flex-shrink: 0;
            border: 1px solid #e3ddd2;
            border-radius: 9px;
            background: white;
            cursor: pointer;
            /* cadangan bila topbar tidak ditemukan */
            position: fixed;
            top: 14px;
            right: 14px;
            z-index: 90;
        }
        .topbar > .menu-toggle { position: static; }
        .menu-toggle span {
            display: block;
            height: 2px;
            border-radius: 2px;
            background: #19152f;
        }

        /* --- Konten memenuhi layar --- */
        .main {
            margin-left: 0 !important;
            width: 100% !important;
            min-width: 0;
        }

        .topbar {
            height: auto !important;
            min-height: 0;
            padding: 14px !important;
            gap: 10px;
        }
        .topbar .welcome { flex: 1; min-width: 0; }
        .topbar .welcome h1 { font-size: 18px; overflow-wrap: anywhere; }
        .topbar .welcome p { font-size: 12px; }
        .topbar .avatar { width: 38px; height: 38px; flex-shrink: 0; }

        .content { padding: 16px 14px 30px !important; }

        .page-header {
            flex-wrap: wrap;
            align-items: flex-start !important;
            gap: 12px;
        }
        .page-header h2 { font-size: 21px !important; }
        .page-header .btn-primary { width: 100%; }

        .stat-row {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 12px;
        }

        .filter-form { flex-wrap: wrap !important; }
        .filter-form .search { width: 100%; flex: none !important; }
        .filter-form .category { flex: 1; min-width: 0; width: auto; }

        /* tabel digeser ke samping, tidak melebarkan halaman */
        .table-card { overflow-x: auto !important; -webkit-overflow-scrolling: touch; }
        .table-card .table { min-width: 560px; }
        .action { flex-wrap: wrap; }

        .pagination { flex-wrap: wrap; gap: 10px; }

        .modal { max-width: calc(100vw - 28px); }
    }
</style>

<script>
    (function () {
        var sidebar = document.getElementById('adminSidebar');
        var overlay = document.getElementById('sidebarOverlay');
        var toggle  = document.getElementById('menuToggle');
        var close   = document.getElementById('sidebarClose');
        if (!sidebar || !toggle) return;

        function placeToggle() {
            var topbar = document.querySelector('.topbar');
            if (topbar && toggle.parentNode !== topbar) topbar.appendChild(toggle);
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', placeToggle);
        } else {
            placeToggle();
        }

        function setOpen(open) {
            sidebar.classList.toggle('open', open);
            overlay.classList.toggle('show', open);
            document.body.classList.toggle('menu-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        toggle.addEventListener('click', function () { setOpen(true); });
        overlay.addEventListener('click', function () { setOpen(false); });
        if (close) close.addEventListener('click', function () { setOpen(false); });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setOpen(false);
        });
        window.addEventListener('resize', function () {
            if (window.innerWidth > 800) setOpen(false);
        });
    })();
</script>
@endonce