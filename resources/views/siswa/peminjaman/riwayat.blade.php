@extends('admin.partials.style')

@section('title', 'Riwayat Peminjaman | SIPUSTAKA')
@section('heading', 'Riwayat Peminjaman')

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

    /* Topbar styling - Responsif agar tidak menabrak di layar kecil */
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
        margin: 0;
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
        text-decoration: none;
    }
    .dropdown-item:hover { background: #efeae0; }
    .dropdown-item.active { background: var(--coral); color: #fff; }
    .dropdown-divider { height: 1px; background: #e8e2d5; margin: 6px 0; }

    /* Main Wrapper Card */
    .main-card-container {
        background: var(--cream);
        border-radius: 24px;
        padding: 32px;
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

    /* Panel & Table Layout */
    .panel {
        background: #fffdfa;
        border: 1px solid #ddd6cc;
        border-radius: 18px;
        overflow: hidden;
        padding: 24px;
    }
    .panel.empty {
        text-align: center;
        color: var(--muted);
        padding: 50px 20px;
        font-size: 14px;
        background: #efeae0;
        border: 1px solid #ddd6cc;
        border-radius: 16px;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }
    .table th {
        padding: 14px 20px;
        background: #f6f2ea;
        color: var(--muted);
        text-align: left;
        font-size: 11px;
        font-weight: bold;
        letter-spacing: .5px;
        border-bottom: 1px solid #e8e2d5;
    }
    .table td {
        padding: 16px 20px;
        border-bottom: 1px solid #e8e2d5;
        color: var(--navy);
        font-size: 13px;
        vertical-align: middle;
    }
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    .table tbody tr:hover {
        background: #fbf8f2;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: bold;
    }
    .badge.success {
        background: rgba(20, 170, 153, .15);
        color: #0f8275;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        padding-top: 20px;
    }
    .pagination svg {
        width: 16px !important;
        height: 16px !important;
        max-width: 16px !important;
        max-height: 16px !important;
    }
</style>

<div class="container-fluid">
    {{-- Topbar dengan Hamburger Menu dan Avatar --}}
    <div class="topbar">
        <div class="welcome">
            <h1>Riwayat Peminjaman</h1>
            <p>Daftar transaksi buku yang sudah selesai dikembalikan.</p>
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
                    <a href="{{ route('siswa.peminjaman.index') }}" class="dropdown-item">🔄 Peminjaman Saya</a>
                    <a href="{{ route('siswa.riwayat') }}" class="dropdown-item active">🕒 Riwayat</a>
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
        @if($riwayat->isEmpty())
            <div class="panel empty">
                Belum ada riwayat pengembalian buku.
            </div>
        @else
            <div class="panel">
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>BUKU</th>
                                <th>JUMLAH</th>
                                <th>TANGGAL PINJAM</th>
                                <th>TANGGAL KEMBALI</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $loan)
                                <tr>
                                    <td><strong>{{ $loan->book->judul_buku ?? 'Buku tidak tersedia' }}</strong></td>
                                    <td>{{ $loan->jumlah }} buku</td>
                                    <td>{{ $loan->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                                    <td>{{ $loan->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                                    <td><span class="badge success">✓ Dikembalikan</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination">{{ $riwayat->links() }}</div>
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
</script>
@endsection