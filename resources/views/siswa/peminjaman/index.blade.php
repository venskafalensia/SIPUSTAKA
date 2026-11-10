@extends('admin.partials.style')

@section('title', 'Peminjaman Saya | SIPUSTAKA')
@section('heading', 'Peminjaman Saya')

@section('content')
<style>
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
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
        background: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, .1);
        padding-bottom: 20px;
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
        margin: 0;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
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
        right: 0;
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
        text-decoration: none;
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

    /* Loan Page Internal Styles */
    .loan-page {
        display: flex;
        flex-direction: column;
        gap: 24px;
        color: var(--navy);
    }

    .loan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 5px;
    }

    .loan-header h2 {
        margin: 0 0 4px;
        font-family: Georgia, serif;
        font-size: 22px;
        font-weight: bold;
        color: var(--navy);
    }

    .loan-header p {
        margin: 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.5;
    }

    .loan-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border: none;
        border-radius: 10px;
        background: var(--coral);
        color: #fff !important;
        font-size: 13px;
        font-weight: bold;
        text-decoration: none !important;
        transition: .2s ease;
        cursor: pointer;
    }

    .loan-btn:hover {
        background: #ed5142;
        transform: translateY(-1px);
    }

    .loan-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
    }

    .loan-stat {
        padding: 20px;
        border: 1px solid #ddd6cc;
        border-radius: 18px;
        background: #efeae0;
    }

    .loan-stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .loan-stat-label {
        color: var(--muted);
        font-size: 12px;
        font-weight: 600;
    }

    .loan-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #e5dfd5;
        color: var(--navy);
        font-size: 16px;
    }

    .loan-stat-number {
        font-size: 26px;
        line-height: 1.2;
        font-family: Georgia, serif;
        font-weight: bold;
        color: var(--navy);
    }

    .loan-stat-note {
        margin-top: 6px;
        color: var(--muted);
        font-size: 11px;
    }

    .loan-stat.pending .loan-stat-icon {
        background: #fff0d6;
        color: #e59a1c;
    }

    .loan-stat.late .loan-stat-icon {
        background: #ffe2dd;
        color: #c2412b;
    }

    .loan-panel {
        overflow: hidden;
        border: 1px solid #ddd6cc;
        border-radius: 18px;
        background: #fffdfa;
    }

    .loan-panel-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px;
        border-bottom: 1px solid #e8e2d5;
    }

    .loan-panel-head h3 {
        margin: 0 0 3px;
        color: var(--navy);
        font-family: Georgia, serif;
        font-size: 17px;
    }

    .loan-panel-head p {
        margin: 0;
        color: var(--muted);
        font-size: 12px;
    }

    .loan-count {
        padding: 6px 12px;
        border-radius: 9px;
        background: #efeae0;
        color: var(--navy);
        font-size: 12px;
        font-weight: bold;
    }

    .loan-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .loan-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .loan-table th {
        padding: 14px 20px;
        background: #f6f2ea;
        color: var(--muted);
        text-align: left;
        font-size: 11px;
        font-weight: bold;
        letter-spacing: .5px;
        border-bottom: 1px solid #e8e2d5;
    }

    .loan-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #e8e2d5;
        color: var(--navy);
        font-size: 13px;
        vertical-align: middle;
    }

    .loan-table tbody tr:last-child td {
        border-bottom: none;
    }

    .loan-table tbody tr:hover {
        background: #fbf8f2;
    }

    .loan-book {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 210px;
        white-space: normal;
    }

    .loan-book-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 40px;
        height: 48px;
        border-radius: 8px;
        background: #eee8ff;
        color: #7755ef;
        font-size: 18px;
    }

    .loan-book-title {
        max-width: 230px;
        color: var(--navy);
        font-size: 13px;
        font-weight: bold;
        line-height: 1.4;
    }

    .loan-book-author {
        margin-top: 3px;
        color: var(--muted);
        font-size: 11px;
    }

    .loan-quantity {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        padding: 5px 9px;
        border-radius: 7px;
        background: #efeae0;
        color: var(--navy);
        font-size: 12px;
        font-weight: bold;
    }

    .loan-date {
        color: var(--navy);
        font-size: 12px;
    }

    .loan-date.late-date {
        color: #c2412b;
        font-weight: bold;
    }

    .loan-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: bold;
    }

    .loan-badge.pending {
        background: #fff0d6;
        color: #b4690e;
    }

    .loan-badge.active {
        background: rgba(20, 170, 153, .15);
        color: #0f8275;
    }

    .loan-badge.late {
        background: #ffe2dd;
        color: #c2412b;
    }

    .loan-badge.returned {
        background: #eee8ff;
        color: #6b4ce6;
    }

    .loan-empty {
        padding: 50px 20px;
        text-align: center;
    }

    .loan-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        border-radius: 16px;
        background: #eee8ff;
        color: #7755ef;
        font-size: 26px;
    }

    .loan-empty h3 {
        margin: 0 0 8px;
        color: var(--navy);
        font-family: Georgia, serif;
        font-size: 16px;
    }

    .loan-empty p {
        max-width: 360px;
        margin: 0 auto 20px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .loan-pagination {
        padding: 16px 20px;
        border-top: 1px solid #e8e2d5;
        background: #fffdfa;
    }

    .loan-pagination nav {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .loan-pagination p {
        font-size: 12px;
        color: var(--muted);
    }

    .pagination svg {
        width: 16px !important;
        height: 16px !important;
    }

    @media (max-width: 800px) {
        .loan-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 480px) {
        .loan-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

@php
    $daftarPeminjaman = $peminjaman;

    $jumlahMenunggu = $daftarPeminjaman->filter(function ($loan) {
        return $loan->status === 'Menunggu'
            && is_null($loan->tanggal_kembali);
    })->count();

    $jumlahTerlambat = $daftarPeminjaman->filter(function ($loan) {
        return is_null($loan->tanggal_kembali)
            && $loan->tanggal_jatuh_tempo
            && $loan->tanggal_jatuh_tempo->lt(today())
            && in_array($loan->status, ['Dipinjam', 'Terlambat'], true);
    })->count();

    $jumlahAktif = $daftarPeminjaman->filter(function ($loan) {
        return is_null($loan->tanggal_kembali)
            && in_array($loan->status, ['Dipinjam', 'Terlambat'], true);
    })->count();
@endphp

<div class="container-fluid">
    {{-- Topbar dengan Hamburger Menu dan Avatar --}}
    <div class="topbar">
        <div class="welcome">
            <h1>Peminjaman Saya</h1>
            <p>Pantau pengajuan, pinjaman aktif, dan batas pengembalian buku kamu.</p>
        </div>

        <div class="topbar-right">
            <div class="dropdown-container">
                <button type="button" class="btn-ghost" onclick="toggleMenu(event)">
                    ☰ Menu Utama
                </button>

                <div class="dropdown-menu-custom" id="dropdownMenu">
                    <div class="menu-section-title">Menu Siswa</div>
                    <a href="{{ route('siswa.dashboard') }}" class="dropdown-item">🏠 Dashboard</a>
                    <a href="{{ route('siswa.katalog.index') }}" class="dropdown-item">📚 Katalog Buku</a>
                    <a href="{{ route('siswa.peminjaman.index') }}" class="dropdown-item active">🔄 Peminjaman Saya</a>
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

    {{-- Kartu Konten Utama Full-Width Landscape --}}
    <div class="main-card-container">
        <div class="loan-page">

            {{-- Header dalam Card --}}
            <div class="loan-header">
                <div>
                    <h2>Daftar Peminjaman Buku</h2>
                    <p>Periksa status dan tanggal pengembalian setiap buku yang Anda pinjam.</p>
                </div>

                <a href="{{ route('siswa.katalog.index') }}" class="loan-btn">
                    <span>＋</span>
                    Cari Buku
                </a>
            </div>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div style="padding:13px 16px;border-radius:10px;background:rgba(20,170,153,.15);color:#0f8275;font-size:13px;border:1px solid rgba(20,170,153,.3);">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="padding:13px 16px;border-radius:10px;background:rgba(255,102,85,.15);color:#c2412b;font-size:13px;border:1px solid rgba(255,102,85,.3);">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div style="padding:13px 16px;border-radius:10px;background:rgba(255,102,85,.15);color:#c2412b;font-size:13px;border:1px solid rgba(255,102,85,.3);">
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin:7px 0 0;padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Statistik --}}
            <div class="loan-stats">
                <div class="loan-stat">
                    <div class="loan-stat-top">
                        <span class="loan-stat-label">Total di halaman ini</span>
                        <span class="loan-stat-icon">▤</span>
                    </div>
                    <div class="loan-stat-number">{{ $daftarPeminjaman->count() }}</div>
                    <div class="loan-stat-note">Data pada halaman yang sedang dibuka</div>
                </div>

                <div class="loan-stat pending">
                    <div class="loan-stat-top">
                        <span class="loan-stat-label">Menunggu persetujuan</span>
                        <span class="loan-stat-icon">◷</span>
                    </div>
                    <div class="loan-stat-number">{{ $jumlahMenunggu }}</div>
                    <div class="loan-stat-note">Pengajuan yang belum diproses admin</div>
                </div>

                <div class="loan-stat late">
                    <div class="loan-stat-top">
                        <span class="loan-stat-label">Terlambat</span>
                        <span class="loan-stat-icon">!</span>
                    </div>
                    <div class="loan-stat-number">{{ $jumlahTerlambat }}</div>
                    <div class="loan-stat-note">Pinjaman melewati tanggal jatuh tempo</div>
                </div>
            </div>

            {{-- Tabel Peminjaman --}}
            <div class="loan-panel">
                <div class="loan-panel-head">
                    <div>
                        <h3>Riwayat Transaksi Peminjaman</h3>
                        <p>Daftar lengkap peminjaman buku Anda.</p>
                    </div>

                    <span class="loan-count">
                        {{ $peminjaman->total() }} transaksi
                    </span>
                </div>

                @if($peminjaman->isEmpty())
                    <div class="loan-empty">
                        <div class="loan-empty-icon">▤</div>
                        <h3>Belum ada peminjaman</h3>
                        <p>
                            Kamu belum memiliki pengajuan atau transaksi peminjaman.
                            Jelajahi katalog untuk menemukan buku yang ingin dibaca.
                        </p>
                        <a href="{{ route('siswa.katalog.index') }}" class="loan-btn">
                            Jelajahi Katalog
                        </a>
                    </div>
                @else
                    <div class="loan-table-wrap">
                        <table class="loan-table">
                            <thead>
                                <tr>
                                    <th>BUKU</th>
                                    <th>JUMLAH</th>
                                    <th>TANGGAL PINJAM</th>
                                    <th>JATUH TEMPO</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($peminjaman as $loan)
                                    @php
                                        $terlambat = is_null($loan->tanggal_kembali)
                                            && $loan->tanggal_jatuh_tempo
                                            && $loan->tanggal_jatuh_tempo->lt(today())
                                            && in_array($loan->status, ['Dipinjam', 'Terlambat'], true);

                                        $status = $loan->status;
                                    @endphp

                                    <tr>
                                        <td>
                                            <div class="loan-book">
                                                <div class="loan-book-icon">▤</div>

                                                <div>
                                                    <div class="loan-book-title">
                                                        {{ $loan->book->judul_buku ?? 'Buku tidak tersedia' }}
                                                    </div>

                                                    <div class="loan-book-author">
                                                        {{ $loan->book->pengarang ?? 'Pengarang tidak diketahui' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="loan-quantity">
                                                {{ $loan->jumlah }} buku
                                            </span>
                                        </td>

                                        <td>
                                            <span class="loan-date">
                                                {{ $loan->tanggal_pinjam?->format('d M Y') ?? 'Belum ditentukan' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="loan-date {{ $terlambat ? 'late-date' : '' }}">
                                                {{ $loan->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            @if($loan->tanggal_kembali !== null || $status === 'Dikembalikan')
                                                <span class="loan-badge returned">
                                                    ✓ Dikembalikan
                                                </span>
                                            @elseif($status === 'Menunggu')
                                                <span class="loan-badge pending">
                                                    ◷ Menunggu Persetujuan
                                                </span>
                                            @elseif($terlambat)
                                                <span class="loan-badge late">
                                                    ! Terlambat
                                                </span>
                                            @elseif(in_array($status, ['Dipinjam', 'Terlambat'], true))
                                                <span class="loan-badge active">
                                                    ● Sedang Dipinjam
                                                </span>
                                            @else
                                                <span class="loan-badge returned">
                                                    {{ $status }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($peminjaman->hasPages())
                        <div class="loan-pagination">
                            {{ $peminjaman->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
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
</script>
@endsection