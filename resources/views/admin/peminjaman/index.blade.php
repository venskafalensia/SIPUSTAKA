@extends('admin.partials.style')

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

    .loan-page {
        color: var(--navy);
        padding-bottom: 35px;
    }

    .loan-page * { box-sizing: border-box; }

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

    /* Topbar styling - Responsif & Tidak Nabrak */
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
        justify-content: flex-end;
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

    /* Posisi dropdown menu diatur left: 0 agar aman di HP */
    .dropdown-menu-custom {
        position: absolute;
        left: 0;
        top: 48px;
        width: 240px;
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

    /* Main Wrapper Card (Warna Krem) */
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

    .loan-page .lp-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .loan-page .lp-eyebrow {
        color: var(--coral);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.8px;
        margin-bottom: 7px;
    }

    .loan-page .lp-heading h2 {
        font-size: 24px;
        font-family: Georgia, serif;
        margin: 0 0 4px;
        color: var(--navy);
    }

    .loan-page .lp-heading p {
        color: var(--muted);
        font-size: 13px;
        margin: 0;
    }

    .loan-page .lp-date {
        background: #efeae0;
        border: 1px solid #ddd6cc;
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 12px;
        color: var(--navy);
        font-weight: bold;
    }

    .loan-page .lp-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }

    .loan-page .lp-stat {
        background: #efeae0;
        border: 1px solid #ddd6cc;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        min-width: 0;
    }

    .loan-page .lp-stat small {
        display: block;
        color: var(--muted);
        font-size: 11px;
        margin-bottom: 6px;
        line-height: 1.5;
    }

    .loan-page .lp-stat strong {
        display: block;
        font-size: 26px;
        font-family: Georgia, serif;
        color: var(--navy);
    }

    .loan-page .lp-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        font-size: 18px;
        flex-shrink: 0;
        font-weight: bold;
    }

    .loan-page .lp-workspace {
        display: grid;
        grid-template-columns: minmax(280px, .75fr) minmax(0, 1.75fr);
        gap: 20px;
        align-items: start;
    }

    .loan-page .lp-card {
        background: #efeae0;
        border: 1px solid #ddd6cc;
        border-radius: 18px;
        padding: 22px;
        min-width: 0;
    }

    .loan-page .lp-card-head { margin-bottom: 18px; }

    .loan-page .lp-card-head h3,
    .loan-page .lp-table-head h3 {
        font-size: 16px;
        font-family: Georgia, serif;
        margin: 0 0 4px;
        color: var(--navy);
    }

    .loan-page .lp-card-head p,
    .loan-page .lp-table-head p {
        color: var(--muted);
        font-size: 12px;
        line-height: 1.5;
        margin: 0;
    }

    .loan-page .lp-field { margin-bottom: 15px; }

    .loan-page .lp-field label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 6px;
        color: var(--navy);
    }

    .loan-page .lp-field select,
    .loan-page .lp-field input {
        display: block;
        width: 100%;
        min-height: 42px;
        border: 1px solid #ddd6cc;
        border-radius: 10px;
        padding: 10px 12px;
        background: #fffdfa;
        color: var(--navy);
        font-family: inherit;
        font-size: 13px;
        outline: none;
    }

    .loan-page .lp-field select:focus,
    .loan-page .lp-field input:focus,
    .loan-page .lp-search input:focus {
        border-color: var(--purple);
        box-shadow: 0 0 0 3px rgba(119, 85, 239, .15);
    }

    .loan-page .lp-primary {
        width: 100%;
        border: none;
        border-radius: 10px;
        background: var(--coral);
        color: white;
        font-weight: bold;
        font-family: inherit;
        font-size: 13px;
        padding: 12px 16px;
        cursor: pointer;
        box-shadow: 0 6px 16px -4px rgba(255, 102, 85, .5);
        transition: transform .2s, background .2s;
    }

    .loan-page .lp-primary:hover {
        background: #f25545;
        transform: translateY(-1px);
    }

    .loan-page .lp-note {
        margin-top: 14px;
        border-radius: 10px;
        padding: 12px;
        background: #fef3c7;
        color: #92400e;
        font-size: 11px;
        line-height: 1.6;
    }

    .loan-page .lp-table-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .loan-page .lp-search {
        display: flex;
        gap: 7px;
        flex-wrap: wrap;
    }

    .loan-page .lp-search input {
        width: 190px;
        max-width: 100%;
        border: 1px solid #ddd6cc;
        border-radius: 10px;
        padding: 10px 12px;
        font-family: inherit;
        font-size: 13px;
        background: #fffdfa;
        outline: none;
        color: var(--navy);
    }

    .loan-page .lp-search button,
    .loan-page .lp-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd6cc;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 12px;
        font-family: inherit;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        background: #fffdfa;
        color: var(--navy);
    }

    .loan-page .lp-search button {
        background: var(--navy);
        border-color: var(--navy);
        color: white;
    }

    .loan-page .lp-table-wrap {
        overflow-x: auto;
        width: 100%;
    }

    .loan-page .lp-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 690px;
    }

    .loan-page .lp-table th {
        text-align: left;
        padding: 14px 12px;
        background: #e2dcd0;
        color: var(--navy);
        font-size: 11px;
        font-weight: bold;
        letter-spacing: .5px;
        white-space: nowrap;
        border-bottom: 1px solid #d4ccc0;
    }

    .loan-page .lp-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #e8e2d5;
        vertical-align: middle;
        color: var(--navy);
    }

    .loan-page .lp-table tbody tr:hover td { background: rgba(0, 0, 0, .02); }

    .loan-page .lp-person,
    .loan-page .lp-book {
        font-weight: bold;
        margin-bottom: 3px;
        color: var(--navy);
    }

    .loan-page .lp-sub {
        color: var(--muted);
        font-size: 11px;
        line-height: 1.4;
    }

    .loan-page .lp-status {
        display: inline-block;
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 11px;
        font-weight: bold;
        white-space: nowrap;
    }

    .loan-page .lp-status.active {
        background: rgba(20, 170, 153, .15);
        color: var(--teal);
    }

    .loan-page .lp-status.late {
        background: #ffe2dd;
        color: #c2412b;
    }

    .loan-page .lp-status.pending {
        background: #fef3c7;
        color: #b45309;
    }

    .loan-page .lp-status.returned {
        background: #eee8ff;
        color: var(--purple);
    }

    .loan-page .lp-approve {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border: 0;
        border-radius: 8px;
        background: var(--teal);
        color: white;
        padding: 8px 12px;
        font-size: 11px;
        font-weight: bold;
        font-family: inherit;
        cursor: pointer;
        white-space: nowrap;
    }

    .loan-page .lp-approve:hover { background: #119688; }

    .loan-page .lp-empty {
        padding: 40px 15px !important;
        text-align: center;
        color: var(--muted);
        line-height: 1.7;
    }

    .loan-page .lp-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 18px;
        font-size: 12px;
        color: var(--muted);
    }

    .loan-page .lp-alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        line-height: 1.6;
    }

    .loan-page .lp-alert.success {
        background: #d1fae5;
        color: #065f46;
    }

    .loan-page .lp-alert.error {
        background: #ffe2dd;
        color: #c2412b;
    }

    @media (max-width: 1200px) {
        .loan-page .lp-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .loan-page .lp-workspace { grid-template-columns: 1fr; }
    }

    @media (max-width: 650px) {
        .loan-page .lp-stats { grid-template-columns: 1fr; gap: 10px; }
        .loan-page .lp-heading h2 { font-size: 20px; }
        .loan-page .lp-card { padding: 16px; }
        .loan-page .lp-search { width: 100%; }
        .loan-page .lp-search input { width: 100%; flex: 1 1 100%; }
    }
</style>

<div class="container-fluid loan-page">
    <div class="topbar">
        <div class="welcome">
            <h1>Manajemen Peminjaman</h1>
            <p>SIPUSTAKA · Panel Administrator</p>
        </div>

        <div class="topbar-right">
            <!-- DROPDOWN MENU HAMBURGER INTERAKTIF -->
            <div class="dropdown-container">
                <button type="button" class="btn-ghost" onclick="toggleMenu(event)">
                    ☰ Menu Utama
                </button>

                <div class="dropdown-menu-custom" id="dropdownMenu">
                    <div class="menu-section-title">Menu Utama</div>
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">🏠 Dashboard</a>
                    <a href="{{ route('admin.books.index') }}" class="dropdown-item">📚 Data Buku</a>
                    <a href="{{ route('admin.kategori.index') }}" class="dropdown-item">🏷️ Kategori</a>
                    <a href="{{ route('admin.anggota.index') }}" class="dropdown-item">👥 Anggota</a>

                    <div class="dropdown-divider"></div>
                    <div class="menu-section-title">Transaksi</div>
                    <a href="{{ route('admin.peminjaman.index') }}" class="dropdown-item active">🔄 Peminjaman</a>
                    <a href="{{ route('admin.pengembalian.index') }}" class="dropdown-item">↩️ Pengembalian</a>
                    <a href="{{ route('admin.laporan.index') }}" class="dropdown-item">📊 Laporan</a>

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.profil.index') }}" class="dropdown-item">⚙️ Profil</a>
                    
                    <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                        @csrf
                        <button type="submit" class="dropdown-item" style="width: 100%; background: none; border: 0; text-align: left; color: #c2412b; cursor: pointer;">
                            🚪 Keluar
                        </button>
                    </form>
                </div>
            </div>

            <div class="avatar">A</div>
        </div>
    </div>

    <div class="main-card-container">

        <div class="lp-heading">
            <div>
                <div class="lp-eyebrow">Sirkulasi Perpustakaan</div>
                <h2>Peminjaman Buku</h2>
                <p>Kelola transaksi langsung dan persetujuan pengajuan peminjaman siswa.</p>
            </div>

            <div class="lp-date">
                📅 {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="lp-alert success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="lp-alert error">
                <strong>Transaksi belum berhasil.</strong>
                <ul style="padding-left:18px;margin:7px 0 0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- STATISTIK --}}
        <div class="lp-stats">
            <div class="lp-stat">
                <div>
                    <small>Total seluruh transaksi</small>
                    <strong>{{ $totalPeminjaman }}</strong>
                </div>
                <div class="lp-stat-icon" style="background:#eee8ff;color:#6848df">▤</div>
            </div>

            <div class="lp-stat">
                <div>
                    <small>Masih dipinjam</small>
                    <strong>{{ $totalAktif }}</strong>
                </div>
                <div class="lp-stat-icon" style="background:#def4ee;color:#148f7c">↗</div>
            </div>

            <div class="lp-stat">
                <div>
                    <small>Menunggu persetujuan</small>
                    <strong>{{ $totalMenungguPersetujuan ?? 0 }}</strong>
                </div>
                <div class="lp-stat-icon" style="background:#fff3d9;color:#986714">◷</div>
            </div>

            <div class="lp-stat">
                <div>
                    <small>Sudah dikembalikan</small>
                    <strong>{{ $totalSelesai }}</strong>
                </div>
                <div class="lp-stat-icon" style="background:#ffe2dd;color:#e75543">✓</div>
            </div>
        </div>

        <div class="lp-workspace">

            {{-- FORM PEMINJAMAN LANGSUNG OLEH ADMIN --}}
            <section class="lp-card">
                <div class="lp-card-head">
                    <h3>＋ Catat Peminjaman Baru</h3>
                    <p>Form ini digunakan admin untuk mencatat transaksi peminjaman secara langsung.</p>
                </div>

                <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                    @csrf

                    <div class="lp-field">
                        <label for="loan-user">Anggota perpustakaan</label>
                        <select id="loan-user" name="user_id" required>
                            <option value="">Pilih anggota</option>
                            @foreach ($anggota as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('user_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} ({{ $member->username }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="lp-field">
                        <label for="loan-book">Buku yang dipinjam</label>
                        <select id="loan-book" name="book_id" required>
                            <option value="">Pilih buku tersedia</option>
                            @foreach ($buku as $book)
                                <option value="{{ $book->id }}"
                                    {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->judul_buku }} — stok {{ $book->stok }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="lp-field">
                        <label for="loan-quantity">Jumlah buku</label>
                        <input id="loan-quantity"
                               type="number"
                               name="jumlah"
                               min="1"
                               value="{{ old('jumlah', 1) }}"
                               required>
                    </div>

                    <div class="lp-field">
                        <label for="loan-due">Tanggal jatuh tempo</label>
                        <input id="loan-due"
                               type="date"
                               name="tanggal_jatuh_tempo"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('tanggal_jatuh_tempo') }}"
                               required>
                    </div>

                    <button type="submit" class="lp-primary">
                        Simpan Peminjaman →
                    </button>

                    <div class="lp-note">
                        <strong>Perhatian:</strong> transaksi melalui form ini
                        langsung berstatus dipinjam. Stok akan berkurang setelah
                        transaksi berhasil disimpan.
                    </div>
                </form>
            </section>

            {{-- TABEL PEMINJAMAN DAN PENGAJUAN --}}
            <section class="lp-card">
                <div class="lp-table-head">
                    <div>
                        <h3>Daftar Peminjaman</h3>
                        <p>Periksa pengajuan siswa dan transaksi yang belum dikembalikan.</p>
                    </div>

                    <form action="{{ route('admin.peminjaman.index') }}"
                          method="GET"
                          class="lp-search">
                        <input type="text"
                               name="q"
                               value="{{ $q }}"
                               placeholder="Cari anggota atau buku...">
                        <button type="submit">Cari</button>
                        <a href="{{ route('admin.peminjaman.index') }}" class="lp-reset">Reset</a>
                    </form>
                </div>

                <div class="lp-table-wrap">
                    <table class="lp-table">
                        <thead>
                            <tr>
                                <th>ANGGOTA / BUKU</th>
                                <th>TANGGAL PINJAM</th>
                                <th>JATUH TEMPO</th>
                                <th>JUMLAH</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($transaksi as $item)
                                @php
                                    $status = $item->status;

                                    $terlambat = in_array($status, ['Dipinjam', 'Terlambat'], true)
                                        && $item->tanggal_jatuh_tempo
                                        && $item->tanggal_jatuh_tempo->lt(today());
                                @endphp

                                <tr>
                                    <td>
                                        <div class="lp-person">
                                            {{ $item->user->name ?? 'Anggota dihapus' }}
                                        </div>
                                        <div class="lp-sub">
                                            {{ $item->user->username ?? '-' }}
                                        </div>

                                        <div class="lp-book" style="margin-top:10px">
                                            {{ $item->book->judul_buku ?? 'Buku dihapus' }}
                                        </div>
                                        <div class="lp-sub">
                                            {{ $item->book->pengarang ?? '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ $item->tanggal_pinjam?->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->tanggal_jatuh_tempo?->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td>{{ $item->jumlah }} buku</td>

                                    <td>
                                        @if ($status === 'Menunggu')
                                            <span class="lp-status pending">Menunggu</span>
                                        @elseif ($status === 'Dikembalikan')
                                            <span class="lp-status returned">Dikembalikan</span>
                                        @elseif ($terlambat || $status === 'Terlambat')
                                            <span class="lp-status late">Terlambat</span>
                                        @elseif ($status === 'Dipinjam')
                                            <span class="lp-status active">Dipinjam</span>
                                        @else
                                            <span class="lp-status pending">
                                                {{ $status ?? 'Tidak diketahui' }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($status === 'Menunggu' && is_null($item->tanggal_kembali))
                                            <form action="{{ route('admin.peminjaman.setujui', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Setujui pengajuan peminjaman buku ini? Stok buku akan dikurangi setelah persetujuan.');">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="lp-approve">
                                                    ✓ Setujui
                                                </button>
                                            </form>
                                        @elseif (in_array($status, ['Dipinjam', 'Terlambat'], true))
                                            <span class="lp-sub">Menunggu pengembalian</span>
                                        @else
                                            <span class="lp-sub">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="lp-empty">
                                        <div style="font-size:30px;margin-bottom:10px">▤</div>
                                        <strong>Belum ada data peminjaman</strong>
                                        <div>Pengajuan siswa dan transaksi admin akan muncul di sini.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="lp-pagination">
                    <span>
                        Menampilkan {{ $transaksi->firstItem() ?? 0 }}–{{ $transaksi->lastItem() ?? 0 }}
                        dari {{ $transaksi->total() }} transaksi
                    </span>

                    <span>{{ $transaksi->links() }}</span>
                </div>
            </section>
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