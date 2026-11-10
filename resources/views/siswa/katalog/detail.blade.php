@extends('admin.partials.style')

@section('title', 'Detail Buku | SIPUSTAKA')
@section('heading', 'Detail Buku')

@section('content')
@php
    // Batas total buku yang boleh dipinjam seorang siswa (pengajuan menunggu + pinjaman aktif).
    // $sisaKuota dikirim dari controller; bila belum ada, dianggap kuota masih penuh.
    $kuotaMaks = (int) ($kuotaMaks ?? 5);
    $sisaKuota = max(0, min($kuotaMaks, (int) ($sisaKuota ?? $kuotaMaks)));
    $terpakai  = $kuotaMaks - $sisaKuota;
    $maksPinjam = max(0, min($sisaKuota, (int) $book->stok));
    $jumlahAwal = max(1, min((int) old('jumlah', 1), max(1, $maksPinjam)));
@endphp

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

    body { background: var(--navy) !important; }

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

    /* Topbar */
    .topbar {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 25px;
        background: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, .1);
        padding-bottom: 20px;
    }
    @media (min-width: 768px) {
        .topbar { flex-direction: row; justify-content: space-between; align-items: center; }
    }
    .welcome h1 { font-family: Georgia, serif; font-size: 26px; margin-bottom: 4px; color: #fff; }
    .welcome p { color: #c9c3de; font-size: 13px; }

    .topbar-right { display: flex; align-items: center; gap: 12px; justify-content: flex-start; }
    @media (min-width: 768px) { .topbar-right { justify-content: flex-end; } }

    .avatar {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        background: #eee8ff;
        color: #6b4ce6;
        font-weight: bold;
    }

    /* Dropdown Menu Hamburger */
    .dropdown-container { position: relative; }

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
    .btn-ghost:hover { background: rgba(255, 255, 255, .2); border-color: rgba(255, 255, 255, .4); }

    .dropdown-menu-custom {
        position: absolute;
        left: 0;
        top: 48px;
        width: 250px;
        background: var(--cream);
        border-radius: 18px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, .5);
        display: none;
        flex-direction: column;
        padding: 12px;
        z-index: 100;
        animation: bdFade .2s ease;
    }
    .dropdown-menu-custom.show { display: flex; }
    @keyframes bdFade { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: none; } }

    .menu-section-title {
        padding: 8px 12px 4px;
        color: var(--muted);
        font-size: 11px;
        font-weight: bold;
        letter-spacing: .5px;
        text-transform: uppercase;
    }
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 10px;
        color: var(--navy);
        font-size: 14px;
        font-weight: 500;
        transition: background .2s;
    }
    .dropdown-item:hover { background: #efeae0; }
    .dropdown-item.active { background: var(--coral); color: #fff; }
    .dropdown-divider { height: 1px; margin: 6px 0; background: #e8e2d5; }

    /* Kartu krem utama */
    .main-card-container {
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        padding: 28px;
        border-radius: 24px;
        background: var(--cream);
        box-shadow: 0 30px 70px -25px rgba(0, 0, 0, .55);
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

    /* ===== Isi detail buku ===== */
    .bd-head { margin-bottom: 20px; }
    .bd-head h2 { margin-bottom: 4px; color: var(--navy); font: 22px Georgia, serif; }
    .bd-head p { color: var(--muted); font-size: 13px; }

    .bd-notice { margin-bottom: 16px; padding: 12px 16px; border-radius: 12px; font-size: 13px; line-height: 1.6; }
    .bd-notice ul { margin: 6px 0 0 18px; }
    .bd-ok  { background: #def4ee; color: #0f7c6b; }
    .bd-err { background: #ffe2dd; color: #c2412b; }

    .bd-grid {
        display: grid;
        grid-template-columns: minmax(150px, 260px) minmax(0, 1fr);
        gap: 30px;
        align-items: start;
    }

    .bd-cover {
        padding: 14px;
        border: 1px solid #e3dccf;
        border-radius: 18px;
        background: #efeae0;
        text-align: center;
    }
    .bd-cover img {
        display: block;
        width: 100%;
        max-height: 340px;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 14px 28px -12px rgba(25, 21, 47, .5);
    }
    .bd-cover-ph {
        height: 240px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: #eee8ff;
        color: #6848df;
        font-size: 46px;
    }

    .bd-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px; }
    .bd-pill { padding: 5px 12px; border-radius: 999px; font-size: 12px; font-weight: bold; }
    .bd-pill.kat { background: #eee8ff; color: #6848df; }
    .bd-pill.ok  { background: #def4ee; color: #148f7c; }
    .bd-pill.out { background: #ffe2dd; color: #d74736; }

    .bd-title { margin: 0 0 6px; color: var(--navy); font: bold 28px/1.25 Georgia, serif; overflow-wrap: anywhere; }
    .bd-author { margin-bottom: 20px; color: var(--muted); font-size: 16px; }

    .bd-facts { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-bottom: 22px; }
    .bd-fact { padding: 12px 14px; border: 1px solid #e3dccf; border-radius: 14px; background: #fffdfa; }
    .bd-fact small { display: block; margin-bottom: 3px; color: var(--muted); font-size: 11px; letter-spacing: .4px; text-transform: uppercase; }
    .bd-fact b { color: var(--navy); font-size: 14px; overflow-wrap: anywhere; }

    .bd-sub { margin-bottom: 8px; color: var(--navy); font: 18px Georgia, serif; }
    .bd-desc { color: #6f6877; font-size: 14px; line-height: 1.8; overflow-wrap: anywhere; }

    /* Kuota */
    .bd-quota {
        max-width: 460px;
        margin: 24px 0 18px;
        padding: 16px;
        border: 1px solid #e3dccf;
        border-radius: 14px;
        background: #faf8f4;
    }
    .bd-quota-head { display: flex; justify-content: space-between; align-items: baseline; gap: 10px; font-size: 13px; color: var(--navy); }
    .bd-quota-head span { color: var(--muted); font-size: 12px; }
    .bd-dots { display: flex; gap: 8px; margin: 12px 0; }
    .bd-dots span { flex: 1; height: 10px; border: 1px solid #ddd6cc; border-radius: 6px; background: #fff; transition: background .2s, border-color .2s; }
    .bd-dots span.used { background: var(--coral); border-color: var(--coral); }
    .bd-dots span.sel  { background: var(--purple); border-color: var(--purple); }
    .bd-quota p { color: var(--muted); font-size: 12px; line-height: 1.6; }

    .bd-full {
        max-width: 480px;
        margin-top: 22px;
        padding: 18px;
        border-radius: 14px;
        background: #fff0d6;
        color: #7a5200;
    }
    .bd-full strong { display: block; margin-bottom: 6px; font-size: 14px; }
    .bd-full p { margin: 0 0 14px; font-size: 13px; line-height: 1.65; }

    /* Form */
    .bd-form { max-width: 460px; }
    .bd-field { display: grid; gap: 7px; margin-bottom: 16px; }
    .bd-field label { color: var(--navy); font-size: 13px; font-weight: bold; }
    .bd-input {
        width: 100%;
        min-height: 46px;
        padding: 0 14px;
        border: 1px solid #ddd6cc;
        border-radius: 11px;
        background: #fffdfa;
        color: var(--navy);
        font: 15px Arial, Helvetica, sans-serif;
        outline: none;
    }
    .bd-input:focus { border-color: var(--purple); box-shadow: 0 0 0 4px rgba(119, 85, 239, .15); }
    .bd-input.invalid { border-color: #e75543; background: #fff6f4; }
    .bd-hint { color: var(--muted); font-size: 12px; }

    .bd-qty { display: flex; align-items: center; gap: 8px; }
    .bd-qty-btn {
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        border: 1px solid #ddd6cc;
        border-radius: 11px;
        background: #fff;
        color: var(--navy);
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
    }
    .bd-qty-btn:hover:not(:disabled) { border-color: var(--purple); color: var(--purple); }
    .bd-qty-btn:disabled { opacity: .4; cursor: not-allowed; }
    .bd-qty .bd-input { width: 92px; padding: 0 8px; text-align: center; font-weight: bold; -moz-appearance: textfield; }
    .bd-qty .bd-input::-webkit-outer-spin-button,
    .bd-qty .bd-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .bd-msg { color: #c2412b; font-size: 12px; font-weight: bold; }

    .bd-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: 0 22px;
        border: 0;
        border-radius: 12px;
        background: var(--coral);
        color: #fff;
        font: bold 14px Arial, Helvetica, sans-serif;
        cursor: pointer;
        box-shadow: 0 10px 22px -10px rgba(255, 102, 85, .8);
        transition: background .2s, transform .2s;
    }
    .bd-btn:hover:not(:disabled) { background: #f25545; transform: translateY(-1px); }
    .bd-btn:disabled { opacity: .5; cursor: not-allowed; }
    .bd-btn-line {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: 0 20px;
        border: 1px solid #ddd6cc;
        border-radius: 12px;
        background: #fff;
        color: var(--navy);
        font: bold 13px Arial, Helvetica, sans-serif;
        cursor: pointer;
    }
    .bd-btn-line:hover { border-color: var(--purple); color: var(--purple); }
    .bd-note { margin-top: 12px; color: var(--muted); font-size: 12px; line-height: 1.6; }
    .bd-back-row { margin-top: 26px; padding-top: 20px; border-top: 1px solid #e3dccf; }

    /* Pop up konfirmasi */
    .bd-modal-bg {
        position: fixed;
        inset: 0;
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: rgba(25, 21, 47, .6);
    }
    .bd-modal-bg[hidden] { display: none; }
    .bd-modal {
        width: 100%;
        max-width: 440px;
        max-height: calc(100vh - 32px);
        overflow-y: auto;
        padding: 24px;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 20px 50px rgba(25, 21, 47, .35);
    }
    .bd-modal h3 { margin: 0 0 6px; color: var(--navy); font: 21px Georgia, serif; }
    .bd-modal p { color: var(--muted); font-size: 13px; line-height: 1.6; }
    .bd-list { margin: 18px 0 14px; }
    .bd-list > div {
        display: grid;
        grid-template-columns: 130px minmax(0, 1fr);
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #eee8df;
        font-size: 13px;
    }
    .bd-list dt { color: var(--muted); }
    .bd-list dd { margin: 0; color: var(--navy); font-weight: bold; overflow-wrap: anywhere; }
    .bd-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px; }

    /* HP */
    @media (max-width: 800px) {
        .container-fluid { padding: 20px 14px; }
        .welcome h1 { font-size: 22px; }
        .main-card-container { padding: 22px 16px; border-radius: 20px; }
        .bd-grid { grid-template-columns: minmax(0, 1fr); gap: 20px; }
        .bd-cover img { max-height: 260px; }
        .bd-cover-ph { height: 200px; }
        .bd-title { font-size: 23px; }
        .bd-form { max-width: none; }
        .bd-btn, .bd-btn-line { width: 100%; }
    }
    @media (max-width: 480px) {
        .bd-list > div { grid-template-columns: 1fr; gap: 2px; }
        .bd-actions { flex-direction: column-reverse; }
        .bd-actions > * { width: 100%; }
    }
</style>

<div class="container-fluid">

    {{-- Topbar dengan Hamburger Menu dan Avatar --}}
    <div class="topbar">
        <div class="welcome">
            <h1>Detail Buku</h1>
            <p>Periksa detail dan ketersediaan sebelum mengajukan peminjaman.</p>
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

    {{-- Kartu Konten Utama --}}
    <div class="main-card-container">

        <div class="bd-head">
            <h2>Informasi Buku</h2>
            <p>Periksa detail dan ketersediaan sebelum mengajukan peminjaman.</p>
        </div>

        {{-- Pesan --}}
        @if(session('success'))
            <div class="bd-notice bd-ok">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="bd-notice bd-err">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="bd-notice bd-err">
                <strong>Periksa kembali data kamu:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bd-grid">

            {{-- Sampul --}}
            <div class="bd-cover">
                @if($book->sampul)
                    <img src="{{ asset('storage/' . $book->sampul) }}" alt="Sampul {{ $book->judul_buku }}">
                @else
                    <div class="bd-cover-ph">▤</div>
                @endif
            </div>

            {{-- Keterangan --}}
            <div>
                <div class="bd-tags">
                    @if($book->kategori)
                        <span class="bd-pill kat">{{ $book->kategori }}</span>
                    @endif

                    @if($book->stok > 0)
                        <span class="bd-pill ok">Tersedia · {{ $book->stok }}</span>
                    @else
                        <span class="bd-pill out">Buku sedang tidak tersedia</span>
                    @endif
                </div>

                <h2 class="bd-title">{{ $book->judul_buku }}</h2>
                <p class="bd-author">{{ $book->pengarang ?: 'Penulis tidak dicantumkan' }}</p>

                <div class="bd-facts">
                    <div class="bd-fact"><small>Penerbit</small><b>{{ $book->penerbit ?: '-' }}</b></div>
                    <div class="bd-fact"><small>ISBN</small><b>{{ $book->isbn ?: '-' }}</b></div>
                    <div class="bd-fact"><small>Kategori</small><b>{{ $book->kategori ?: '-' }}</b></div>
                    <div class="bd-fact"><small>Tahun terbit</small><b>{{ $book->tahun_terbit ?: '-' }}</b></div>
                    <div class="bd-fact"><small>Stok</small><b>{{ $book->stok }}</b></div>
                </div>

                <h3 class="bd-sub">Deskripsi</h3>
                <p class="bd-desc">{{ $book->deskripsi ?: 'Belum ada deskripsi untuk buku ini.' }}</p>

                @if($book->stok > 0 && $sisaKuota > 0)

                    {{-- KUOTA PEMINJAMAN --}}
                    <div class="bd-quota" id="quota">
                        <div class="bd-quota-head">
                            <strong>Kuota peminjaman</strong>
                            <span>{{ $terpakai }}/{{ $kuotaMaks }} buku terpakai</span>
                        </div>
                        <div class="bd-dots" aria-hidden="true">
                            @for($i = 1; $i <= $kuotaMaks; $i++)
                                <span class="{{ $i <= $terpakai ? 'used' : '' }}"></span>
                            @endfor
                        </div>
                        <p>
                            Kamu hanya boleh meminjam maksimal {{ $kuotaMaks }} buku sekaligus
                            (termasuk pengajuan yang masih menunggu). Sisa kuota kamu
                            <strong>{{ $sisaKuota }} buku</strong>.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('siswa.peminjaman.store') }}"
                          class="bd-form" id="loanForm" novalidate>
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">

                        <div class="bd-field">
                            <label for="jumlah">Jumlah buku</label>

                            <div class="bd-qty">
                                <button type="button" class="bd-qty-btn" id="qtyMinus" aria-label="Kurangi jumlah">−</button>
                                <input class="bd-input" type="number" id="jumlah" name="jumlah"
                                       min="1" max="{{ $maksPinjam }}" step="1" inputmode="numeric"
                                       value="{{ $jumlahAwal }}" required>
                                <button type="button" class="bd-qty-btn" id="qtyPlus" aria-label="Tambah jumlah">+</button>
                            </div>

                            <span class="bd-msg" id="qtyMsg" role="alert" hidden></span>
                            <span class="bd-hint">
                                Bisa meminjam sampai {{ $maksPinjam }} buku
                                @if($book->stok < $sisaKuota)
                                    (sesuai stok buku ini)
                                @else
                                    (sesuai sisa kuota kamu)
                                @endif.
                            </span>
                        </div>

                        <div class="bd-field">
                            <label for="tanggal_jatuh_tempo">Rencana tanggal jatuh tempo</label>
                            <input class="bd-input" type="date" id="tanggal_jatuh_tempo"
                                   name="tanggal_jatuh_tempo"
                                   min="{{ today()->format('Y-m-d') }}"
                                   value="{{ old('tanggal_jatuh_tempo', today()->addDays(7)->format('Y-m-d')) }}"
                                   required>
                        </div>

                        <button type="submit" class="bd-btn" id="loanSubmit">Ajukan Peminjaman</button>
                    </form>

                    <p class="bd-note">
                        Pengajuan perlu disetujui admin. Stok belum dikurangi pada tahap pengajuan.
                    </p>

                @elseif($book->stok > 0)

                    {{-- KUOTA PENUH --}}
                    <div class="bd-full">
                        <strong>Kuota peminjaman kamu sudah penuh</strong>
                        <p>
                            Kamu sedang meminjam atau mengajukan {{ $kuotaMaks }} buku, yaitu batas maksimal.
                            Kembalikan buku terlebih dahulu atau tunggu pengajuanmu diproses
                            sebelum meminjam buku lain.
                        </p>
                        <a href="{{ route('siswa.peminjaman.index') }}" class="bd-btn-line">Lihat Peminjaman Saya</a>
                    </div>

                @else

                    <div class="bd-full">
                        <strong>Buku sedang tidak tersedia</strong>
                        <p>Stok buku ini sedang habis. Coba cek lagi nanti atau pilih buku lain dari katalog.</p>
                    </div>

                @endif

                <div class="bd-back-row">
                    <a href="{{ route('siswa.katalog.index') }}" class="bd-btn-line">← Kembali ke Katalog</a>
                </div>
            </div>
        </div>

    </div>
</div>


{{-- ================= POP UP KONFIRMASI PEMINJAMAN ================= --}}
<div class="bd-modal-bg" id="loanConfirm" role="dialog" aria-modal="true"
     aria-labelledby="loanConfirmTitle" hidden>
    <div class="bd-modal">
        <h3 id="loanConfirmTitle">Konfirmasi Peminjaman</h3>
        <p>Periksa kembali data pengajuan kamu sebelum dikirim.</p>

        <dl class="bd-list">
            <div><dt>Peminjam</dt><dd>{{ auth()->user()->name }}</dd></div>
            <div><dt>Judul buku</dt><dd>{{ $book->judul_buku }}</dd></div>
            <div><dt>Penulis</dt><dd>{{ $book->pengarang ?: '-' }}</dd></div>
            <div><dt>Jumlah</dt><dd id="cfJumlah">-</dd></div>
            <div><dt>Sisa kuota</dt><dd id="cfKuota">-</dd></div>
            <div><dt>Tanggal pengajuan</dt><dd id="cfTglAjukan">-</dd></div>
            <div><dt>Jatuh tempo</dt><dd id="cfTempo">-</dd></div>
        </dl>

        <p style="margin-bottom:0">
            Pengajuan perlu disetujui admin. Stok belum dikurangi pada tahap pengajuan.
        </p>

        <div class="bd-actions">
            <button type="button" class="bd-btn-line" id="cfCancel">Tidak, batalkan</button>
            <button type="button" class="bd-btn" id="cfOk">Ya, pinjam</button>
        </div>
    </div>
</div>


<script>
    /* ===== Menu hamburger (dropdown) ===== */
    function toggleMenu(event) {
        event.stopPropagation();
        document.getElementById('dropdownMenu').classList.toggle('show');
    }

    window.addEventListener('click', function (event) {
        var menu = document.getElementById('dropdownMenu');
        if (menu && !event.target.closest('.dropdown-container')) {
            menu.classList.remove('show');
        }
    });

    /* ===== Batas jumlah, kuota, dan konfirmasi peminjaman ===== */
    (function () {
        var form  = document.getElementById('loanForm');
        var modal = document.getElementById('loanConfirm');
        if (!form || !modal) return;

        var MAKS     = {{ (int) $maksPinjam }};
        var TERPAKAI = {{ (int) $terpakai }};
        var KUOTA    = {{ (int) $kuotaMaks }};

        var qty    = document.getElementById('jumlah');
        var minus  = document.getElementById('qtyMinus');
        var plus   = document.getElementById('qtyPlus');
        var msg    = document.getElementById('qtyMsg');
        var submit = document.getElementById('loanSubmit');
        var dots   = document.querySelectorAll('#quota .bd-dots span');
        var okBtn     = document.getElementById('cfOk');
        var cancelBtn = document.getElementById('cfCancel');
        var lastFocus = null;

        function cekJumlah() {
            var raw = qty.value.trim();
            var v   = parseInt(raw, 10);
            var err = '';

            if (raw === '' || isNaN(v) || v < 1) {
                err = 'Jumlah minimal 1 buku.';
            } else if (v > MAKS) {
                err = 'Jumlah melebihi batas. Kamu hanya bisa meminjam maksimal ' + MAKS + ' buku sekarang.';
            }

            msg.hidden = !err;
            msg.textContent = err;
            qty.classList.toggle('invalid', !!err);
            submit.disabled = !!err;
            minus.disabled = !isNaN(v) && v <= 1;
            plus.disabled  = !isNaN(v) && v >= MAKS;

            var pilih = (!err && !isNaN(v)) ? v : 0;
            dots.forEach(function (d, i) {
                d.classList.toggle('sel', i >= TERPAKAI && i < TERPAKAI + pilih);
            });

            return !err;
        }

        qty.addEventListener('input', cekJumlah);
        qty.addEventListener('blur', function () {
            var v = parseInt(qty.value, 10);
            qty.value = isNaN(v) ? 1 : Math.max(1, Math.min(v, MAKS));
            cekJumlah();
        });
        minus.addEventListener('click', function () {
            qty.value = Math.max(1, (parseInt(qty.value, 10) || 1) - 1);
            cekJumlah();
        });
        plus.addEventListener('click', function () {
            qty.value = Math.min((parseInt(qty.value, 10) || 0) + 1, MAKS);
            cekJumlah();
        });
        cekJumlah();

        function formatTanggal(d) {
            return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        }
        function parseIso(v) {
            var p = (v || '').split('-');
            return p.length === 3 ? new Date(+p[0], +p[1] - 1, +p[2]) : null;
        }

        function openModal() {
            var jumlah = parseInt(qty.value, 10) || 0;
            var tempo  = parseIso(form.querySelector('[name="tanggal_jatuh_tempo"]').value);

            document.getElementById('cfJumlah').textContent    = jumlah + ' buku';
            document.getElementById('cfKuota').textContent     =
                Math.max(0, KUOTA - TERPAKAI - jumlah) + ' dari ' + KUOTA + ' buku';
            document.getElementById('cfTglAjukan').textContent = formatTanggal(new Date());
            document.getElementById('cfTempo').textContent     = tempo ? formatTanggal(tempo) : '-';

            lastFocus = document.activeElement;
            okBtn.disabled = false;
            okBtn.textContent = 'Ya, pinjam';
            modal.hidden = false;
            document.body.style.overflow = 'hidden';
            cancelBtn.focus();
        }

        function closeModal() {
            modal.hidden = true;
            document.body.style.overflow = '';
            if (lastFocus && lastFocus.focus) lastFocus.focus();
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!cekJumlah()) { qty.focus(); return; }
            if (!form.checkValidity()) { form.reportValidity(); return; }
            openModal();
        });

        okBtn.addEventListener('click', function () {
            okBtn.disabled = true;
            okBtn.textContent = 'Mengirim...';
            form.submit();
        });

        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.hidden) closeModal();
        });
        window.addEventListener('pageshow', function () {
            okBtn.disabled = false;
            okBtn.textContent = 'Ya, pinjam';
            if (!modal.hidden) closeModal();
        });
    })();
</script>
@endsection