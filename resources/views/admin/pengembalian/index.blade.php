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

    .return-page {
        color: var(--navy);
        padding-bottom: 35px;
    }

    .return-page * { box-sizing: border-box; }

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

    /* Topbar styling - Posisi natural dan rapi */
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

    .return-page .rp-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 25px;
    }

    .return-page .rp-eyebrow {
        color: var(--coral);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.8px;
        margin-bottom: 7px;
    }

    .return-page .rp-heading h2 {
        font-size: 24px;
        font-family: Georgia, serif;
        margin: 0 0 4px;
        color: var(--navy);
    }

    .return-page .rp-heading p {
        color: var(--muted);
        font-size: 13px;
        margin: 0;
    }

    .return-page .rp-date {
        background: #efeae0;
        border: 1px solid #ddd6cc;
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 12px;
        color: var(--navy);
        font-weight: bold;
    }

    .return-page .rp-alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        line-height: 1.6;
    }

    .return-page .rp-alert.success {
        background: #d1fae5;
        color: #065f46;
    }

    .return-page .rp-alert.error {
        background: #ffe2dd;
        color: #c2412b;
    }

    .return-page .rp-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .return-page .rp-stat {
        position: relative;
        overflow: hidden;
        background: #efeae0;
        border: 1px solid #ddd6cc;
        border-radius: 16px;
        padding: 20px;
    }

    .return-page .rp-stat:after {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #c7b7f4;
    }

    .return-page .rp-stat.warning:after {
        background: var(--coral);
    }

    .return-page .rp-stat.complete:after {
        background: #36b58d;
    }

    .return-page .rp-stat small {
        display: block;
        color: var(--muted);
        font-size: 11px;
        margin-bottom: 6px;
    }

    .return-page .rp-stat strong {
        display: block;
        font-size: 26px;
        font-family: Georgia, serif;
        color: var(--navy);
    }

    .return-page .rp-stat p {
        font-size: 11px;
        color: var(--muted);
        margin: 6px 0 0;
    }

    .return-page .rp-panel {
        background: #efeae0;
        border: 1px solid #ddd6cc;
        border-radius: 18px;
        padding: 22px;
        min-width: 0;
    }

    .return-page .rp-panel-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .return-page .rp-panel-head h3 {
        font-size: 16px;
        font-family: Georgia, serif;
        margin: 0 0 4px;
        color: var(--navy);
    }

    .return-page .rp-panel-head p {
        color: var(--muted);
        font-size: 12px;
        line-height: 1.5;
        margin: 0;
    }

    .return-page .rp-count {
        display: inline-block;
        background: #ffe2dd;
        color: #c2412b;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: bold;
        white-space: nowrap;
    }

    .return-page .rp-search {
        display: flex;
        gap: 7px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .return-page .rp-search input {
        flex: 1 1 220px;
        min-width: 0;
        border: 1px solid #ddd6cc;
        border-radius: 10px;
        padding: 10px 12px;
        font-family: inherit;
        font-size: 13px;
        background: #fffdfa;
        outline: none;
        color: var(--navy);
    }

    .return-page .rp-search input:focus {
        border-color: var(--purple);
        box-shadow: 0 0 0 3px rgba(119, 85, 239, .15);
    }

    .return-page .rp-search button,
    .return-page .rp-reset {
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

    .return-page .rp-search button {
        background: var(--navy);
        color: white;
        border-color: var(--navy);
    }

    .return-page .rp-table-wrap {
        overflow-x: auto;
        width: 100%;
    }

    .return-page .rp-table {
        width: 100%;
        min-width: 750px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .return-page .rp-table th {
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

    .return-page .rp-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #e8e2d5;
        vertical-align: middle;
        color: var(--navy);
    }

    .return-page .rp-table tbody tr:hover td {
        background: rgba(0, 0, 0, .02);
    }

    .return-page .rp-person,
    .return-page .rp-book {
        font-weight: bold;
        color: var(--navy);
        margin-bottom: 3px;
    }

    .return-page .rp-sub {
        color: var(--muted);
        font-size: 11px;
    }

    .return-page .rp-status {
        display: inline-block;
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 11px;
        font-weight: bold;
        white-space: nowrap;
    }

    .return-page .rp-status.waiting {
        background: #eee8ff;
        color: var(--purple);
    }

    .return-page .rp-status.late {
        background: #ffe2dd;
        color: #c2412b;
    }

    .return-page .rp-return-btn {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        background: rgba(20, 170, 153, .15);
        color: var(--teal);
        font-family: inherit;
        font-size: 11px;
        font-weight: bold;
        cursor: pointer;
        white-space: nowrap;
        transition: .2s;
    }

    .return-page .rp-return-btn:hover {
        background: rgba(20, 170, 153, .25);
        transform: translateY(-1px);
    }

    .return-page .rp-empty {
        padding: 40px 15px !important;
        text-align: center;
        color: var(--muted);
        line-height: 1.7;
    }

    .return-page .rp-empty-icon {
        display: grid;
        place-items: center;
        width: 50px;
        height: 50px;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: #d1fae5;
        color: #065f46;
        font-size: 22px;
    }

    .return-page .rp-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 18px;
        color: var(--muted);
        font-size: 12px;
    }

    .return-page .rp-info {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-top: 20px;
        padding: 16px;
        border: 1px solid #fef3c7;
        border-radius: 12px;
        background: #fef9c3;
        color: #854d0e;
        font-size: 12px;
        line-height: 1.7;
    }

    .return-page .rp-info-icon {
        flex-shrink: 0;
        font-size: 18px;
    }

    @media (max-width: 850px) {
        .return-page .rp-stats {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .return-page .rp-heading h2 {
            font-size: 20px;
        }

        .return-page .rp-panel {
            padding: 16px;
        }
    }
</style>

<div class="container-fluid return-page">
    <div class="topbar">
        <div class="welcome">
            <h1>Manajemen Pengembalian</h1>
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
                    <a href="{{ route('admin.peminjaman.index') }}" class="dropdown-item">🔄 Peminjaman</a>
                    <a href="{{ route('admin.pengembalian.index') }}" class="dropdown-item active">↩️ Pengembalian</a>
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

        {{-- JUDUL HALAMAN --}}
        <div class="rp-heading">
            <div>
                <div class="rp-eyebrow">Kontrol Sirkulasi</div>
                <h2>Pengembalian Buku</h2>
                <p>Periksa keterlambatan dan selesaikan transaksi pengembalian anggota.</p>
            </div>

            <div class="rp-date">
                📅 {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="rp-alert success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rp-alert error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rp-alert error">
                <strong>Pengembalian belum berhasil.</strong>
                <ul style="padding-left:18px;margin:7px 0 0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- RINGKASAN --}}
        <div class="rp-stats">
            <div class="rp-stat">
                <small>Menunggu Pengembalian</small>
                <strong>{{ $totalMenunggu }}</strong>
                <p>Transaksi yang masih aktif</p>
            </div>

            <div class="rp-stat warning">
                <small>Terlambat Dikembalikan</small>
                <strong>{{ $totalTerlambat }}</strong>
                <p>Sudah melewati tanggal jatuh tempo</p>
            </div>

            <div class="rp-stat complete">
                <small>Total Sudah Dikembalikan</small>
                <strong>{{ $totalDikembalikan }}</strong>
                <p>Transaksi yang telah selesai</p>
            </div>
        </div>

        {{-- DAFTAR PENGEMBALIAN --}}
        <section class="rp-panel">
            <div class="rp-panel-head">
                <div>
                    <h3>Daftar Pengembalian Aktif</h3>
                    <p>Pastikan buku telah diterima sebelum menekan tombol proses.</p>
                </div>

                <div class="rp-count">
                    {{ $totalMenunggu }} transaksi menunggu
                </div>
            </div>

            {{-- PENCARIAN --}}
            <form action="{{ route('admin.pengembalian.index') }}"
                  method="GET"
                  class="rp-search">

                <input type="text"
                       name="q"
                       value="{{ request('q', '') }}"
                       placeholder="Cari nama anggota, username, atau judul buku...">

                <button type="submit">Cari Transaksi</button>

                <a href="{{ route('admin.pengembalian.index') }}"
                   class="rp-reset">
                    Reset
                </a>
            </form>

            {{-- TABEL --}}
            <div class="rp-table-wrap">
                <table class="rp-table">
                    <thead>
                        <tr>
                            <th>ANGGOTA</th>
                            <th>INFORMASI BUKU</th>
                            <th>TANGGAL PINJAM</th>
                            <th>JATUH TEMPO</th>
                            <th>JUMLAH</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>
                     @forelse ($aktif as $item)
                            @php
                                $tanggalTempo = $item->tanggal_jatuh_tempo
                                    ? \Illuminate\Support\Carbon::parse($item->tanggal_jatuh_tempo)
                                    : null;

                                $terlambat = $tanggalTempo
                                    && $tanggalTempo->lt(now()->startOfDay());
                            @endphp

                            <tr>
                                <td>
                                    <div class="rp-person">
                                        {{ $item->user->name ?? 'Anggota dihapus' }}
                                    </div>
                                    <div class="rp-sub">
                                        {{ $item->user->username ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="rp-book">
                                        {{ $item->book->judul_buku ?? 'Buku dihapus' }}
                                    </div>
                                    <div class="rp-sub">
                                        {{ $item->book->pengarang ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $item->tanggal_pinjam ? \Illuminate\Support\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}
                                </td>

                                <td>
                                    {{ $item->tanggal_jatuh_tempo ? \Illuminate\Support\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}
                                </td>

                                <td>{{ $item->jumlah }} buku</td>

                                <td>
                                    @if ($terlambat)
                                        <span class="rp-status late">
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="rp-status waiting">
                                            Menunggu
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <form
                                        action="{{ route('admin.pengembalian.proses', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Pastikan buku sudah diterima. Proses pengembalian dan tambahkan stok buku kembali?');">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="rp-return-btn">
                                            ✓ Proses Kembali
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="rp-empty">
                                    <div class="rp-empty-icon">✓</div>
                                    <strong>Tidak ada pengembalian yang menunggu</strong>
                                    <div>
                                        Semua transaksi aktif sudah diproses
                                        atau belum ada peminjaman.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="rp-pagination">
                <span>
                    Menampilkan {{ $aktif->firstItem() ?? 0 }}–{{ $aktif->lastItem() ?? 0 }}
                    dari {{ $aktif->total() }} transaksi
                </span>

                <span>{{ $aktif->links() }}</span>
            </div>
        </section>

        {{-- PETUNJUK --}}
        <div class="rp-info">
            <div class="rp-info-icon">ⓘ</div>
            <div>
                <strong>Informasi pengembalian</strong><br>
                Setelah tombol Proses Kembali ditekan dan transaksi berhasil,
                sistem akan mencatat tanggal pengembalian, mengubah status
                menjadi Dikembalikan, serta menambahkan jumlah buku ke stok.
                Pastikan buku sudah diterima oleh petugas sebelum memproses.
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