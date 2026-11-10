@extends('admin.partials.style')

@section('content')
@php
    // Pembantu tampilan
    $sampul = fn ($b) => $b->sampul ? asset('storage/' . $b->sampul) : null;
    $namaSiswa = $user->name ?? auth()->user()->name;
    $inisial = strtoupper(mb_substr($namaSiswa, 0, 2));

    $terlaris = collect($bukuTerlaris ?? [])->filter(fn ($i) => $i->book)->values();
    $maksPinjam = max(1, (int) $terlaris->max('total_pinjam'));
@endphp

<style>
    :root {
        --navy: #19152f;
        --coral: #ff4631;
        --amber: #f6a52e;
        --teal: #14aa99;
        --purple: #7755ef;
        --cream: #f8f5ef;
        --muted: #8a829b;
    }

    body { background: var(--navy) !important; }

    /* ===== Latar: cahaya warna ===== */
    body::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background:
            radial-gradient(700px 500px at 85% -10%, rgba(255, 86, 67, 0.29), transparent 70%),
            radial-gradient(600px 500px at 5% 105%, rgba(20, 170, 153, .30), transparent 70%),
            radial-gradient(500px 400px at 50% 40%, rgba(119, 85, 239, .18), transparent 70%);
    }

    .sd-wrap {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 1280px;
        margin: 0 auto;
        padding: 22px 20px 40px;
    }
    .sd-wrap a { color: inherit; text-decoration: none; }

    /* ===== Animasi masuk ===== */
    .sd-rise { animation: sdRise .7s cubic-bezier(.2, .7, .2, 1) backwards; animation-delay: var(--d, 0s); }
    @keyframes sdRise {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: none; }
    }

    /* ===== Topbar ===== */
    .sd-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 22px;
    }
    .sd-brand { display: flex; align-items: center; gap: 11px; color: #fff; }
    .sd-logo { display: flex; align-items: flex-end; gap: 3px; height: 26px; }
    .sd-logo span { display: block; width: 6px; border-radius: 3px; }
    .sd-logo span:nth-child(1) { height: 14px; background: var(--coral); }
    .sd-logo span:nth-child(2) { height: 21px; background: var(--amber); }
    .sd-logo span:nth-child(3) { height: 17px; background: var(--teal); }
    .sd-logo span:nth-child(4) { height: 25px; background: var(--purple); }
    .sd-brand strong { font: bold 20px Georgia, serif; letter-spacing: .3px; }

    .sd-top-right { display: flex; align-items: center; gap: 12px; }
    .sd-avatar {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: #eee8ff;
        color: #6b4ce6;
        font-weight: bold;
    }

    /* Menu hamburger (dropdown) */
    .sd-menu { position: relative; }
    .sd-menu-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        height: 42px;
        padding: 0 16px;
        border: 1px solid rgba(255, 255, 255, .22);
        border-radius: 12px;
        background: rgba(255, 255, 255, .1);
        color: #fff;
        font: bold 13px Arial, Helvetica, sans-serif;
        cursor: pointer;
        transition: background .15s, border-color .15s;
    }
    .sd-menu-btn:hover { background: rgba(255, 255, 255, .2); border-color: rgba(255, 255, 255, .4); }

    .sd-dropdown {
        position: absolute;
        right: 0;
        top: 52px;
        z-index: 200;
        width: 260px;
        display: none;
        flex-direction: column;
        padding: 12px;
        border-radius: 18px;
        background: var(--cream);
        box-shadow: 0 20px 50px rgba(0, 0, 0, .5);
    }
    .sd-dropdown.show { display: flex; animation: sdPop .2s ease; }
    @keyframes sdPop {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: none; }
    }
    .sd-dd-title {
        padding: 8px 12px 4px;
        color: var(--muted);
        font-size: 11px;
        font-weight: bold;
        letter-spacing: .5px;
        text-transform: uppercase;
    }
    .sd-dd-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 12px;
        border-radius: 10px;
        color: var(--navy);
        font-size: 14px;
        font-weight: 500;
        transition: background .2s;
    }
    .sd-dd-item:hover { background: #efeae0; }
    .sd-dd-item.active { background: var(--coral); color: #fff; }
    .sd-dd-line { height: 1px; margin: 6px 0; background: #e8e2d5; }

    /* ===== Hero ===== */
    .sd-hero {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: minmax(0, 1.25fr) minmax(0, 1fr);
        gap: 26px;
        align-items: center;
        margin-bottom: 22px;
        padding: 34px 36px;
        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 26px;
        background: linear-gradient(135deg, rgba(255, 255, 255, .09), rgba(255, 255, 255, .03));
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
        color: #fff;
    }
    .sd-chip {
        display: inline-block;
        padding: 6px 13px;
        border-radius: 999px;
        background: rgba(249, 59, 38, 0.2);
        color: #ffb3a9;
        font-size: 12px;
        font-weight: bold;
    }
    .sd-hero h1 { margin: 14px 0 8px; font: bold 34px/1.2 Georgia, serif; }
    .sd-hero h1 em {
        font-style: normal;
        background: linear-gradient(90deg, var(--coral), var(--amber));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    .sd-hero p.sd-sub { color: #c9c3de; font-size: 14px; line-height: 1.7; }

    .sd-search {
        display: flex;
        gap: 10px;
        margin-top: 22px;
        padding: 7px;
        border-radius: 16px;
        background: #fffdfa;
        box-shadow: 0 16px 34px -14px rgba(0, 0, 0, .6);
    }
    .sd-search input {
        flex: 1;
        min-width: 0;
        height: 46px;
        padding: 0 14px;
        border: 0;
        background: transparent;
        color: var(--navy);
        font: 16px Arial, Helvetica, sans-serif;
        outline: none;
    }
    .sd-search input::placeholder { color: #aaa2b8; }
    .sd-search button {
        height: 46px;
        padding: 0 22px;
        border: 0;
        border-radius: 11px;
        background: var(--coral);
        color: #fff;
        font: bold 14px Arial, Helvetica, sans-serif;
        cursor: pointer;
        transition: background .2s, transform .2s;
    }
    .sd-search button:hover { background: #f25545; transform: translateY(-1px); }

    .sd-hero-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 16px;
        color: #fff;
        font-size: 13px;
        font-weight: bold;
        border-bottom: 2px solid var(--amber);
        padding-bottom: 2px;
    }

    /* statistik dalam hero */
    .sd-stats { display: grid; gap: 12px; position: relative; z-index: 1; }
    .sd-stat {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 18px;
        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 16px;
        background: rgba(255, 255, 255, .07);
        transition: transform .2s, border-color .2s;
    }
    .sd-stat:hover { transform: translateX(4px); border-color: var(--c); }
    .sd-stat-ic {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 13px;
        background: var(--bg);
        font-size: 20px;
    }
    .sd-stat b { display: block; font: bold 26px Georgia, serif; line-height: 1; }
    .sd-stat small { display: block; margin-top: 4px; color: #c9c3de; font-size: 12px; }

    /* batang buku dekoratif */
    .sd-spines {
        position: absolute;
        right: 22px;
        bottom: 0;
        display: flex;
        align-items: flex-end;
        gap: 7px;
        opacity: .16;
        pointer-events: none;
    }
    .sd-spines span {
        width: 16px;
        border-radius: 6px 6px 0 0;
        transform-origin: bottom;
        animation: sdGrow 4.8s ease-in-out infinite;
    }
    .sd-spines span:nth-child(1) { height: 70px;  background: var(--coral);  }
    .sd-spines span:nth-child(2) { height: 104px; background: var(--amber);  animation-delay: .6s; }
    .sd-spines span:nth-child(3) { height: 58px;  background: var(--teal);   animation-delay: 1.2s; }
    .sd-spines span:nth-child(4) { height: 120px; background: var(--purple); animation-delay: 1.8s; }
    .sd-spines span:nth-child(5) { height: 84px;  background: #e5806f;       animation-delay: 2.4s; }
    @keyframes sdGrow { 0%, 100% { transform: scaleY(1); } 50% { transform: scaleY(.74); } }

    /* ===== Kartu krem utama ===== */
    .sd-main {
        position: relative;
        overflow: hidden;
        padding: 30px 28px 24px;
        border-radius: 26px;
        background: var(--cream);
        box-shadow: 0 30px 70px -25px rgba(0, 0, 0, .55);
    }
    .sd-main::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 5px;
        background: linear-gradient(90deg,
            #230e0c 0 25%, #f6a52e 25% 50%,
            #14aa99 50% 75%, #7755ef 75% 100%);
    }

    .sd-section { margin-top: 30px; color: var(--navy); }
    .sd-section:first-child { margin-top: 0; }
    .sd-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
    .sd-title { display: flex; align-items: center; gap: 11px; min-width: 0; }
    .sd-title h2 { font: 19px Georgia, serif; line-height: 1.25; }
    .sd-title p { margin-top: 2px; color: var(--muted); font-size: 12px; }
    .sd-ic {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: var(--bg);
        font-size: 18px;
    }
    .sd-all { color: var(--coral); font-size: 12px; font-weight: bold; white-space: nowrap; }
    .sd-all:hover { text-decoration: underline; }

    .sd-two { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 28px; margin-top: 30px; }
    .sd-two .sd-section { margin-top: 0; }

    /* ===== Kartu buku ===== */
    .sd-grid-3 { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; }
    .sd-grid-4 { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }

    .sd-bcard {
        position: relative;
        display: flex;
        gap: 14px;
        padding: 14px;
        border: 1px solid #e3dccf;
        border-radius: 16px;
        background: #fffdfa;
        transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
    }
    .sd-bcard::before {
        content: "";
        position: absolute;
        left: 0;
        top: 14px;
        bottom: 14px;
        width: 4px;
        border-radius: 0 4px 4px 0;
        background: var(--ac, var(--purple));
    }
    .sd-bcard:hover {
        transform: translateY(-4px);
        border-color: var(--ac, var(--purple));
        box-shadow: 0 16px 30px -18px rgba(25, 21, 47, .5);
    }

    .sd-cover {
        flex: 0 0 58px;
        width: 58px;
        height: 82px;
        display: grid;
        place-items: center;
        overflow: hidden;
        border-radius: 9px;
        background: #eee8ff;
        color: #6848df;
        font-size: 22px;
        box-shadow: 0 6px 14px -6px rgba(25, 21, 47, .45);
    }
    .sd-cover img { display: block; width: 100%; height: 100%; object-fit: cover; }

    .sd-binfo { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 4px; }
    .sd-binfo h4 {
        font-size: 14px;
        line-height: 1.3;
        overflow-wrap: anywhere;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .sd-author {
        color: var(--muted);
        font-size: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sd-tags { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }
    .sd-tag {
        padding: 3px 8px;
        border-radius: 6px;
        background: var(--purple);
        color: #fff;
        font-size: 10px;
        font-weight: bold;
        letter-spacing: .5px;
    }
    .sd-pill { padding: 3px 9px; border-radius: 999px; font-size: 11px; font-weight: bold; }
    .sd-pill.ok   { background: #def4ee; color: #148f7c; }
    .sd-pill.out  { background: #ffe2dd; color: #d74736; }
    .sd-pill.kat  { background: #eee8ff; color: #6848df; }
    .sd-go {
        margin-top: auto;
        padding-top: 4px;
        color: var(--coral);
        font-size: 12px;
        font-weight: bold;
        transition: transform .2s;
    }
    .sd-bcard:hover .sd-go { transform: translateX(4px); }

    .sd-bcard.compact .sd-cover { flex-basis: 52px; width: 52px; height: 74px; }

    /* ===== Papan terlaris ===== */
    .sd-board { display: grid; gap: 10px; }
    .sd-rank-row {
        position: relative;
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 12px 14px 12px 16px;
        border: 1px solid #e3dccf;
        border-radius: 16px;
        background: #fffdfa;
        transition: transform .2s ease, border-color .2s ease;
    }
    .sd-rank-row::before {
        content: "";
        position: absolute;
        left: 0;
        top: 14px;
        bottom: 14px;
        width: 4px;
        border-radius: 0 4px 4px 0;
        background: var(--ac);
    }
    .sd-rank-row:hover { transform: translateX(4px); border-color: var(--ac); }
    .sd-rank {
        width: 30px;
        height: 30px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: var(--ac);
        color: #fff;
        font: bold 14px Georgia, serif;
    }
    .sd-rank-row .sd-cover { flex-basis: 44px; width: 44px; height: 62px; font-size: 18px; }
    .sd-meter { height: 6px; margin-top: 7px; border-radius: 6px; background: #efeae0; overflow: hidden; }
    .sd-meter i { display: block; height: 100%; border-radius: 6px; background: var(--ac); }
    .sd-total { display: block; margin-top: 5px; color: var(--coral); font-size: 12px; font-weight: bold; }

    /* ===== Timeline peminjaman ===== */
    .sd-timeline { position: relative; display: grid; gap: 14px; padding-left: 26px; list-style: none; }
    .sd-timeline::before {
        content: "";
        position: absolute;
        left: 8px;
        top: 6px;
        bottom: 6px;
        width: 2px;
        background: #e3dccf;
    }
    .sd-tl-item {
        position: relative;
        padding: 12px 14px;
        border: 1px solid #e3dccf;
        border-radius: 14px;
        background: #fffdfa;
    }
    .sd-tl-item::before {
        content: "";
        position: absolute;
        left: -26px;
        top: 17px;
        width: 14px;
        height: 14px;
        border: 3px solid var(--cream);
        border-radius: 50%;
        background: var(--st);
        box-shadow: 0 0 0 2px var(--st);
    }
    .sd-tl-item strong { display: block; font-size: 14px; line-height: 1.3; }
    .sd-tl-meta { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-top: 7px; font-size: 12px; color: var(--muted); }
    .sd-status {
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: bold;
        background: var(--stbg);
        color: var(--st);
    }
    .st-wait { --st: #b9770e; --stbg: #fff0d6; }
    .st-out  { --st: #6848df; --stbg: #eee8ff; }
    .st-late { --st: #c2412b; --stbg: #ffe2dd; }
    .st-done { --st: #148f7c; --stbg: #def4ee; }
    .st-gray { --st: #8a829b; --stbg: #efeae0; }

    .sd-empty {
        padding: 22px 16px;
        border: 1px dashed #d6cfc2;
        border-radius: 14px;
        background: #fffdfa;
        color: var(--muted);
        font-size: 13px;
        text-align: center;
        line-height: 1.7;
    }
    .sd-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 9px 16px;
        border-radius: 10px;
        background: var(--coral);
        color: #fff !important;
        font-size: 12px;
        font-weight: bold;
    }

    /* ===== Tablet ===== */
    @media (max-width: 1000px) {
        .sd-hero { grid-template-columns: minmax(0, 1fr); padding: 28px 26px; }
        .sd-stats { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .sd-stat { flex-direction: column; align-items: flex-start; gap: 10px; }
        .sd-stat:hover { transform: translateY(-3px); }
        .sd-spines { display: none; }
        .sd-two { grid-template-columns: minmax(0, 1fr); }
        .sd-grid-3 { grid-template-columns: minmax(0, 1fr); }
        .sd-grid-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    /* ===== HP ===== */
    @media (max-width: 640px) {
        .sd-wrap { padding: 16px 14px 32px; }
        .sd-menu-label { display: none; }
        .sd-menu-btn { width: 42px; padding: 0; justify-content: center; }
        .sd-brand strong { font-size: 18px; }

        .sd-hero { padding: 22px 18px; border-radius: 22px; }
        .sd-hero h1 { font-size: 25px; }
        .sd-search { flex-direction: column; padding: 8px; }
        .sd-search button { width: 100%; }
        .sd-stats { gap: 9px; }
        .sd-stat { padding: 12px; }
        .sd-stat b { font-size: 22px; }
        .sd-stat small { font-size: 11px; }

        .sd-main { padding: 26px 16px 20px; border-radius: 22px; }
        .sd-title h2 { font-size: 17px; }

        /* koleksi pilihan: geser ke samping */
        .sd-scroll {
            display: flex;
            gap: 12px;
            margin: 0 -16px;
            padding: 4px 16px 10px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }
        .sd-scroll .sd-bcard { flex: 0 0 82%; scroll-snap-align: start; }
        .sd-grid-4.sd-scroll { grid-template-columns: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        .sd-rise, .sd-spines span { animation: none; }
        .sd-bcard, .sd-rank-row, .sd-stat { transition: none; }
    }
</style>

<div class="sd-wrap">

    {{-- ===== TOPBAR ===== --}}
    <div class="sd-top sd-rise">
        <a href="{{ route('siswa.dashboard') }}" class="sd-brand">
            <span class="sd-logo"><span></span><span></span><span></span><span></span></span>
            <strong>SIPUSTAKA</strong>
        </a>

        <div class="sd-top-right">
            {{-- MENU HAMBURGER LENGKAP SISWA --}}
            <div class="sd-menu">
                <button type="button" class="sd-menu-btn" id="sdMenuBtn"
                        aria-haspopup="true" aria-expanded="false" aria-controls="sdDropdown">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.4" stroke-linecap="round" aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span class="sd-menu-label">Menu Utama</span>
                </button>

                <div class="sd-dropdown" id="sdDropdown">
                    <div class="sd-dd-title">Menu Siswa</div>
                    <a href="{{ route('siswa.dashboard') }}" class="sd-dd-item active">🏠 Dashboard</a>
                    <a href="{{ route('siswa.katalog.index') }}" class="sd-dd-item">📚 Katalog Buku</a>
                    <a href="{{ route('siswa.peminjaman.index') }}" class="sd-dd-item">🔄 Peminjaman Saya</a>
                    <a href="{{ route('siswa.riwayat') }}" class="sd-dd-item">🕒 Riwayat</a>
                    <a href="{{ route('siswa.profil.edit') }}" class="sd-dd-item">⚙️ Profil Saya</a>

                    <div class="sd-dd-line"></div>
                    <form action="{{ route('logout') }}" method="POST" style="width:100%">
                        @csrf
                        <button type="submit" class="sd-dd-item"
                                style="width:100%;background:none;border:0;text-align:left;color:#c2412b;cursor:pointer;font-family:inherit">
                            🚪 Keluar
                        </button>
                    </form>
                </div>
            </div>

            <div class="sd-avatar" title="{{ $namaSiswa }}">{{ $inisial }}</div>
        </div>
    </div>


    {{-- ===== HERO: sapaan, pencarian, statistik ===== --}}
    <section class="sd-hero sd-rise" style="--d:.08s">
        <div>
            <span class="sd-chip">Dashboard Siswa</span>
            <h1>Mau baca <em>apa hari ini?</em></h1>
            <p class="sd-sub">
                Selamat datang kembali, {{ $namaSiswa }}!
                @isset($totalJudul)
                    {{ number_format($totalJudul, 0, ',', '.') }} judul buku siap kamu pinjam.
                @endisset
            </p>

            <form action="{{ route('siswa.katalog.index') }}" method="GET" class="sd-search" role="search">
                <input type="text" name="q" placeholder="Cari judul, penulis, atau penerbit…" aria-label="Cari buku">
                <button type="submit">Cari Buku</button>
            </form>

            <a href="{{ route('siswa.katalog.index') }}" class="sd-hero-link">Jelajahi seluruh katalog →</a>
        </div>

        {{-- Statistik Ringkasan Peminjaman Siswa --}}
        <div class="sd-stats">
            <div class="sd-stat" style="--c:#f6a52e;--bg:rgba(246,165,46,.2)">
                <span class="sd-stat-ic">⏳</span>
                <div><b>{{ $totalMenunggu ?? 0 }}</b><small>Menunggu Persetujuan</small></div>
            </div>
            <div class="sd-stat" style="--c:#7755ef;--bg:rgba(119,85,239,.25)">
                <span class="sd-stat-ic">📖</span>
                <div><b>{{ $totalDipinjam ?? 0 }}</b><small>Sedang Dipinjam</small></div>
            </div>
            <div class="sd-stat" style="--c:#ff6655;--bg:rgba(255,102,85,.22)">
                <span class="sd-stat-ic">⚠️</span>
                <div><b style="{{ ($totalTerlambat ?? 0) > 0 ? 'color:#ff9a8d' : '' }}">{{ $totalTerlambat ?? 0 }}</b><small>Terlambat</small></div>
            </div>
        </div>

        <div class="sd-spines" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
    </section>


    {{-- ===== ISI UTAMA ===== --}}
    <div class="sd-main sd-rise" style="--d:.16s">

        {{-- 3 Buku Terbaru --}}
        <section class="sd-section">
            <div class="sd-head">
                <div class="sd-title">
                    <span class="sd-ic" style="--bg:#eee8ff">📚</span>
                    <div>
                        <h2>3 Buku Terbaru</h2>
                        <p>Koleksi baru di perpustakaan. Jadi yang pertama membacanya!</p>
                    </div>
                </div>
                <a href="{{ route('siswa.katalog.index') }}" class="sd-all">Semua →</a>
            </div>

            @if(isset($bukuBaru) && count($bukuBaru) > 0)
                <div class="sd-grid-3">
                    @foreach($bukuBaru as $buku)
                        <a href="{{ route('siswa.katalog.show', $buku) }}" class="sd-bcard" style="--ac:#7755ef">
                            <div class="sd-cover">
                                @if($sampul($buku))
                                    <img src="{{ $sampul($buku) }}" alt="Sampul {{ $buku->judul_buku }}" loading="lazy">
                                @else
                                    <span>▤</span>
                                @endif
                            </div>

                            <div class="sd-binfo">
                                <div class="sd-tags">
                                    <span class="sd-tag">BARU</span>
                                    @if($buku->kategori)<span class="sd-pill kat">{{ $buku->kategori }}</span>@endif
                                </div>
                                <h4>{{ $buku->judul_buku }}</h4>
                                <p class="sd-author">{{ $buku->pengarang ?: 'Penulis tidak dicantumkan' }}</p>
                                @if($buku->stok > 0)
                                    <span class="sd-pill ok" style="align-self:flex-start">Stok tersedia: {{ $buku->stok }}</span>
                                @else
                                    <span class="sd-pill out" style="align-self:flex-start">Stok habis</span>
                                @endif
                                <span class="sd-go">{{ $buku->stok > 0 ? 'Pinjam sekarang →' : 'Lihat detail →' }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="sd-empty">Belum ada data buku terbaru.</div>
            @endif
        </section>


        {{-- Terlaris + Peminjaman Terbaru berdampingan --}}
        <div class="sd-two">

            {{-- 3 Buku Terlaris --}}
            <section class="sd-section">
                <div class="sd-head">
                    <div class="sd-title">
                        <span class="sd-ic" style="--bg:#ffe2dd">🔥</span>
                        <div>
                            <h2>3 Buku Sering Dipinjam (Terlaris)</h2>
                            <p>Paling favorit di antara teman-temanmu.</p>
                        </div>
                    </div>
                </div>

                @if($terlaris->count() > 0)
                    <div class="sd-board">
                        @foreach($terlaris as $item)
                            @php
                                $buku = $item->book;
                                $persen = max(14, (int) round($item->total_pinjam / $maksPinjam * 100));
                                $warna = ['#ff6655', '#f6a52e', '#14aa99'][$loop->index] ?? '#7755ef';
                            @endphp

                            <a href="{{ route('siswa.katalog.show', $buku) }}" class="sd-rank-row" style="--ac:{{ $warna }}">
                                <span class="sd-rank">{{ $loop->iteration }}</span>

                                <div class="sd-cover">
                                    @if($sampul($buku))
                                        <img src="{{ $sampul($buku) }}" alt="Sampul {{ $buku->judul_buku }}" loading="lazy">
                                    @else
                                        <span>▤</span>
                                    @endif
                                </div>

                                <div class="sd-binfo">
                                    <h4>{{ $buku->judul_buku }}</h4>
                                    <p class="sd-author">{{ $buku->pengarang ?: 'Penulis tidak dicantumkan' }}</p>
                                    <div class="sd-meter"><i style="width:{{ $persen }}%"></i></div>
                                    <span class="sd-total">Total Dipinjam: {{ $item->total_pinjam }}x</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="sd-empty">Belum ada data buku terlaris.<br>Jadilah yang pertama meminjam!</div>
                @endif
            </section>


            {{-- Peminjaman Terbaru Anda --}}
            <section class="sd-section">
                <div class="sd-head">
                    <div class="sd-title">
                        <span class="sd-ic" style="--bg:#def4ee">🕒</span>
                        <div>
                            <h2>Peminjaman Terbaru Anda</h2>
                            <p>Pantau status buku yang kamu pinjam.</p>
                        </div>
                    </div>
                    <a href="{{ route('siswa.peminjaman.index') }}" class="sd-all">Semua →</a>
                </div>

                @if(isset($peminjamanTerbaru) && count($peminjamanTerbaru) > 0)
                    <ul class="sd-timeline">
                        @foreach($peminjamanTerbaru as $loan)
                            @php
                                $telat = ! $loan->tanggal_kembali
                                    && $loan->tanggal_jatuh_tempo
                                    && $loan->tanggal_jatuh_tempo->lt(today())
                                    && in_array($loan->status, ['Dipinjam', 'Terlambat']);

                                $label = $telat ? 'Terlambat' : $loan->status;
                                $kelas = match (true) {
                                    $telat => 'st-late',
                                    $loan->status === 'Menunggu' => 'st-wait',
                                    $loan->status === 'Dipinjam' => 'st-out',
                                    $loan->status === 'Dikembalikan' => 'st-done',
                                    default => 'st-gray',
                                };
                            @endphp

                            <li class="sd-tl-item {{ $kelas }}">
                                <strong>{{ $loan->book->judul_buku ?? 'Buku' }}</strong>
                                <div class="sd-tl-meta">
                                    <span>Status:</span>
                                    <span class="sd-status">{{ $label }}</span>
                                    @if(! $loan->tanggal_kembali && $loan->tanggal_jatuh_tempo)
                                        <span>Jatuh tempo {{ $loan->tanggal_jatuh_tempo->format('d M Y') }}</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="sd-empty">
                        Belum ada riwayat peminjaman buku.<br>
                        <a href="{{ route('siswa.katalog.index') }}" class="sd-btn">Cari buku pertamamu</a>
                    </div>
                @endif
            </section>

        </div>


        {{-- Koleksi Buku Pilihan --}}
        <section class="sd-section">
            <div class="sd-head">
                <div class="sd-title">
                    <span class="sd-ic" style="--bg:#fff0d6">✨</span>
                    <div>
                        <h2>Koleksi Buku Pilihan</h2>
                        <p>Rekomendasi bacaan yang siap dipinjam.</p>
                    </div>
                </div>
                <a href="{{ route('siswa.katalog.index') }}" class="sd-all">Lihat semua →</a>
            </div>

            @if(isset($bukuPilihan) && count($bukuPilihan) > 0)
                <div class="sd-grid-4 sd-scroll">
                    @foreach($bukuPilihan as $buku)
                        <a href="{{ route('siswa.katalog.show', $buku) }}" class="sd-bcard compact" style="--ac:#14aa99">
                            <div class="sd-cover">
                                @if($sampul($buku))
                                    <img src="{{ $sampul($buku) }}" alt="Sampul {{ $buku->judul_buku }}" loading="lazy">
                                @else
                                    <span>▤</span>
                                @endif
                            </div>

                            <div class="sd-binfo">
                                <h4>{{ $buku->judul_buku }}</h4>
                                <p class="sd-author">{{ $buku->pengarang ?: 'Penulis tidak dicantumkan' }}</p>
                                <span class="sd-pill ok" style="align-self:flex-start">Stok tersedia: {{ $buku->stok }}</span>
                                <span class="sd-go">Lihat detail →</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="sd-empty">Belum ada buku pilihan saat ini.</div>
            @endif
        </section>

    </div>
</div>

<script>
    (function () {
        var btn  = document.getElementById('sdMenuBtn');
        var menu = document.getElementById('sdDropdown');
        if (!btn || !menu) return;

        function setOpen(open) {
            menu.classList.toggle('show', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            setOpen(!menu.classList.contains('show'));
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.sd-menu')) setOpen(false);
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setOpen(false);
        });
    })();
</script>
@endsection