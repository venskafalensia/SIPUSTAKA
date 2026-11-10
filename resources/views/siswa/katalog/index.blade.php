@extends('admin.partials.style')

@section('title', 'Katalog Buku | SIPUSTAKA')
@section('heading', 'Katalog Buku')

@section('content')

<style>
    /* Perbaikan ukuran pagination dan ikon SVG agar normal */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        margin-top: 25px;
    }
    .pagination svg {
        width: 16px !important;
        height: 16px !important;
        max-width: 16px !important;
        max-height: 16px !important;
        display: inline-block;
        vertical-align: middle;
    }
    .pagination nav div {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .pagination span, .pagination a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border-radius: 8px;
        background: #fffdfa;
        border: 1px solid #ddd6cc;
        color: var(--navy);
        font-size: 13px;
        text-decoration: none;
    }
    .pagination span[aria-current="page"] span,
    .pagination .active span {
        background: var(--purple) !important;
        color: #fff !important;
        border-color: var(--purple) !important;
    }
    
    :root {
        --navy: #19152f;
        --coral: #ff6655;
        --amber: #f6a52e;
        --teal: #14aa99;
        --purple: #7755ef;
        --cream: #f8f5ef;
        --muted: #8a829b;
    }

    body {
        background: var(--navy) !important;
    }

    /* Latar belakang efek glow */
    body::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background:
            radial-gradient(700px 500px at 85% -10%, rgba(255, 102, 85, .35), transparent 70%),
            radial-gradient(600px 500px at 5% 105%, rgba(20, 170, 153, .30), transparent 70%),
            radial-gradient(500px 400px at 50% 40%, rgba(119, 85, 239, .18), transparent 70%);
    }

    .container-fluid {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Topbar styling */
    .topbar {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 25px;
        background: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, .1);
        padding-bottom: 20px;
    }

    @media(min-width: 768px) {
        .topbar {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .welcome h1 {
        font-family: Georgia, serif;
        font-size: 26px;
        margin-bottom: 4px;
        color: #fff;
    }

    .welcome p {
        color: #c9c3de;
        font-size: 13px;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
        justify-content: flex-start;
    }

    @media(min-width: 768px) {
        .topbar-right {
            justify-content: flex-end;
        }
    }

    .avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #eee8ff;
        color: #6b4ce6;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        flex-shrink: 0;
    }

    /* Dropdown Menu Hamburger */
    .dropdown-container {
        position: relative;
    }

    .btn-ghost {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 16px;
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 10px;
        background: rgba(255, 255, 255, .1);
        color: #fff;
        font: bold 13px Arial, Helvetica, sans-serif;
        cursor: pointer;
        transition: all .15s;
    }
    .btn-ghost:hover {
        background: rgba(255, 255, 255, .2);
        border-color: rgba(255, 255, 255, .4);
    }

    .dropdown-menu-custom {
        position: absolute;
        left: 0;
        top: 48px;
        width: 250px;
        background: var(--cream);
        border-radius: 18px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        display: none;
        flex-direction: column;
        padding: 12px;
        z-index: 100;
        animation: fadeIn .2s ease;
    }
    .dropdown-menu-custom.show { display: flex; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: none; }
    }

    .menu-section-title {
        font-size: 11px;
        font-weight: bold;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 8px 12px 4px 12px;
    }

    .dropdown-item {
        padding: 10px 12px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        color: var(--navy);
        transition: background .2s;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .dropdown-item:hover { background: #efeae0; }
    .dropdown-item.active { background: var(--coral); color: #fff; }
    .dropdown-divider { height: 1px; background: #e8e2d5; margin: 6px 0; }

    /* Main Wrapper Card */
    .main-card-container {
        background: var(--cream);
        border-radius: 24px;
        padding: 28px;
        box-shadow: 0 30px 70px -25px rgba(0, 0, 0, .55);
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
    }
    .main-card-container::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 5px;
        z-index: 1;
        background: linear-gradient(90deg,
            #ff6655 0 25%, #f6a52e 25% 50%,
            #14aa99 50% 75%, #7755ef 75% 100%);
    }

    /* Halaman Header di dalam container */
    .page-header {
        margin-bottom: 20px;
    }
    .page-header h2 {
        font-family: Georgia, serif;
        font-size: 22px;
        color: var(--navy);
        margin-bottom: 4px;
    }
    .page-header p {
        color: var(--muted);
        font-size: 13px;
        margin: 0;
    }

    /* Filter panel & form styling */
    .panel {
        background: #efeae0;
        border: 1px solid #ddd6cc;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 20px;
    }
    .panel.empty {
        text-align: center;
        color: var(--muted);
        padding: 30px;
    }
    
    .filter-form {
        display: flex;
        gap: 10px;
        flex-wrap: nowrap;
        align-items: center;
    }

    .input {
        border: 1px solid #ddd6cc;
        border-radius: 10px;
        padding: 10px 14px;
        background: #fffdfa;
        color: var(--navy);
        font-size: 13px;
        outline: none;
        height: 42px;
        box-sizing: border-box;
    }
    .input:focus {
        border-color: var(--purple);
        box-shadow: 0 0 0 3px rgba(119,85,239,.15);
    }

    .filter-search {
        flex: 2;
        min-width: 0;
    }

    .filter-select {
        flex: 1.5;
        min-width: 0;
    }
    
    .btn-dark {
        background: var(--navy);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0 16px;
        height: 42px;
        font-weight: bold;
        font-size: 13px;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-dark:hover { background: #2a2150; }

    .btn-outline {
        background: transparent;
        color: var(--navy);
        border: 1px solid #ddd6cc;
        border-radius: 10px;
        padding: 0 16px;
        height: 42px;
        font-weight: bold;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        flex-shrink: 0;
        box-sizing: border-box;
    }
    .btn-outline:hover { background: #e5dfd5; }

    /* Kartu buku */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }
    .book-card {
        overflow: hidden;
        position: relative;
        background: #fffdfa;
        border: 1px solid #ddd6cc;
        border-radius: 18px;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform .35s ease, border-color .35s ease, box-shadow .35s ease;
    }
    /* Efek hover + menyala bergantian (seperti kartu fitur di login) */
    .book-card:hover,
    .book-card.on {
        transform: translateY(-6px);
        border-color: var(--purple);
        box-shadow: 0 16px 34px -14px var(--purple);
    }

    /* Area sampul */
    .book-cover {
        width: 100%;
        height: 190px;
        min-height: 190px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #eee8ff;
        padding: 10px;
        box-sizing: border-box;
    }
    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        transition: transform .5s cubic-bezier(.2, .7, .2, 1);
    }
    /* Zoom sampul */
    .book-card:hover .book-cover img,
    .book-card.on .book-cover img {
        transform: scale(1.08);
    }

    /* Informasi buku */
    .book-info {
        position: relative;
        z-index: 1;
        background: #fffdfa;
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .book-info h4 {
        margin: 0 0 6px;
        font-size: 15px;
        line-height: 1.4;
        color: var(--navy);
        font-weight: bold;
        overflow-wrap: anywhere;
    }
    .book-info p {
        margin: 0 0 6px;
        color: var(--muted);
        font-size: 13px;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: bold;
        margin-top: 5px;
    }
    .badge.success {
        background: rgba(20, 170, 153, .15);
        color: #0f8275;
    }
    .badge.danger {
        background: rgba(255, 102, 85, .15);
        color: #c2412b;
    }

    .book-detail-link {
        margin-top: auto;
        padding-top: 15px;
    }
    .btn-primary {
        background: var(--purple);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: bold;
        font-size: 13px;
        text-align: center;
        text-decoration: none;
        display: block;
        width: 100%;
        box-sizing: border-box;
        transition: background .15s;
    }
    .btn-primary:hover {
        background: #623fe0;
    }

    .muted { color: var(--muted); }
    .small { font-size: 13px; }
        .book-card.on {
        transform: translateY(-6px) !important;
        border-color: var(--purple) !important;
        box-shadow: 0 16px 34px -14px var(--purple) !important;
    }
    .book-card.on .book-cover img {
        transform: scale(1.08) !important;
    }

    @media (prefers-reduced-motion: reduce) {
        .book-card, .book-cover img { transition: none; }
    }
</style>

<div class="container-fluid">
    <!-- Topbar dengan Hamburger Menu dan Avatar -->
    <div class="topbar">
        <div class="welcome">
            <h1>Katalog Buku</h1>
            <p>Jelajahi koleksi buku perpustakaan SIPUSTAKA.</p>
        </div>

        <div class="topbar-right">
            <div class="dropdown-container">
                <button type="button" class="btn-ghost" onclick="toggleMenu(event)">
                    ☰ Menu Utama
                </button>

                <div class="dropdown-menu-custom" id="dropdownMenu">
                    <div class="menu-section-title">Menu Siswa</div>
                    <a href="{{ route('siswa.dashboard') }}" class="dropdown-item">🏠 Dashboard</a>
                    <a href="{{ route('siswa.katalog.index') }}" class="dropdown-item active">📚 Katalog Buku</a>
                    <a href="{{ route('siswa.peminjaman.index') }}" class="dropdown-item">🔄 Peminjaman Saya</a>
                    <a href="{{ route('siswa.riwayat') }}" class="dropdown-item">🕒 Riwayat</a>
                    <a href="{{ route('siswa.profil.edit') }}" class="dropdown-item">⚙️ Profil Saya</a>

                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                        @csrf
                        <button type="submit" class="dropdown-item" style="width: 100%; background: none; border: 0; text-align: left; color: #c2412b; cursor: pointer;">
                            🚪 Keluar
                        </button>
                    </form>
                </div>
            </div>

            <div class="avatar">{{ strtoupper(mb_substr(auth()->user()->name ?? 'U', 0, 2)) }}</div>
        </div>
    </div>

    <!-- Kartu Konten Utama Full-Width Landscape -->
    <div class="main-card-container">

        <div class="page-header">
            <h2>Jelajahi Koleksi Buku</h2>
            <p>Temukan buku yang ingin kamu baca.</p>
        </div>

        <div class="panel">
            <form method="GET"
                  action="{{ route('siswa.katalog.index') }}"
                  class="filter-form">

                <input
                    class="input filter-search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari judul, penulis, atau penerbit..."
                >

                <select class="input filter-select" name="kategori">
                    <option value="">Semua kategori</option>

                    @foreach($kategori as $item)
                        <option value="{{ $item }}"
                            @selected(request('kategori') === $item)>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>

                <button class="btn-dark" type="submit">
                    Cari Buku
                </button>

                <a class="btn-outline"
                   href="{{ route('siswa.katalog.index') }}">
                    Reset
                </a>
            </form>
        </div>

        <p class="muted small" style="margin-bottom:15px">
            Ditemukan {{ $buku->total() }} buku.
        </p>

        @if($buku->isEmpty())

            <div class="panel empty">
                Buku yang kamu cari tidak ditemukan.
            </div>

        @else

            <div class="book-grid">

                @foreach($buku as $book)

                    <article class="book-card">

                        {{-- Sampul buku --}}
                        <div class="book-cover">

                            @if($book->sampul)

                                <img
                                    src="{{ asset('storage/' . $book->sampul) }}"
                                    alt="Sampul {{ $book->judul_buku }}"
                                >

                            @else

                                <span style="font-size:40px;color:#6c4ce8">
                                    ▤
                                </span>

                            @endif

                        </div>

                        {{-- Informasi buku --}}
                        <div class="book-info">

                            <h4>
                                {{ $book->judul_buku }}
                            </h4>

                            <p>
                                {{ $book->pengarang ?: 'Penulis tidak dicantumkan' }}
                            </p>

                            <p>
                                {{ $book->kategori ?: 'Tanpa kategori' }}
                            </p>

                            @if($book->stok > 0)

                                <span class="badge success">
                                    Tersedia · {{ $book->stok }}
                                </span>

                            @else

                                <span class="badge danger">
                                    Stok habis
                                </span>

                            @endif

                            <div class="book-detail-link">
                                <a
                                    href="{{ route('siswa.katalog.show', $book) }}"
                                    class="btn-primary">
                                    Detail Buku
                                </a>
                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

            <div class="pagination">
                {{ $buku->links() }}
            </div>

        @endif

    </div>
</div>

<script>
    function toggleMenu(event) {
        event.stopPropagation();
        document.getElementById('dropdownMenu').classList.toggle('show');
    }

    window.onclick = function(event) {
        let menu = document.getElementById('dropdownMenu');
        if (menu && !event.target.closest('.dropdown-container')) {
            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
            }
        }
    }

    // Kartu buku menyala bergantian (tanpa perlu hover)
    (function () {
        const items = document.querySelectorAll('.book-grid .book-card');
        if (!items.length) return;

        let i = 0;
        function nyala() {
            items.forEach(function (el) { el.classList.remove('on'); });
            items[i % items.length].classList.add('on');
            i++;
        }

        nyala(); // langsung menyala di kartu pertama
        setInterval(nyala, 2000); // pindah tiap 2 detik
    })();
</script>
@endsection