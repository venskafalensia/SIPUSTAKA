<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#19152f">
    <title>Dashboard Admin - SIPUSTAKA</title>
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

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--navy);
            background: var(--navy);
            overflow-x: hidden;
            padding: 30px 20px;
        }

        button, input { font: inherit; }
        a { color: inherit; text-decoration: none; }

        /* ===== Latar Belakang Glow ===== */
        .glow {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(620px 440px at 88% -6%, rgba(255, 102, 85, .38), transparent 70%),
                radial-gradient(560px 460px at 4% 104%, rgba(20, 170, 153, .34), transparent 70%),
                radial-gradient(460px 340px at 50% 38%, rgba(119, 85, 239, .20), transparent 70%);
        }

        .page {
            position: relative;
            z-index: 1;
            max-width: 1150px;
            margin: 0 auto;
        }

        /* Top Header */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            color: #fff;
            flex-wrap: wrap;
            gap: 15px;
            position: relative;
        }
        .top-header h1 { font: bold 28px Georgia, serif; }
        .top-header p { font-size: 13px; color: #c9c3de; margin-top: 4px; }

        /* Hamburger Menu Styling */
        .hamburger-container {
            position: relative;
        }
        .btn-hamburger {
            background: rgba(255, 255, 255, .1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .2);
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background .2s;
        }
        .btn-hamburger:hover { background: rgba(255, 255, 255, .2); }

        /* Dropdown Menu Box */
        .dropdown-menu-custom {
            position: absolute;
            right: 0;
            top: 50px;
            width: 240px;
            background: var(--cream);
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            display: none;
            flex-direction: column;
            padding: 12px;
            z-index: 99;
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

        /* Statistik Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        .stat-card {
            background: var(--cream);
            padding: 22px;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,.4);
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, var(--coral), var(--amber), var(--teal), var(--purple));
        }
        .stat-card h4 { font-size: 13px; color: var(--muted); margin-bottom: 6px; }
        .stat-card .number { font: bold 28px Georgia, serif; color: var(--navy); }

        /* Grid Section untuk Tabel */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        /* Kartu Utama */
        .card {
            position: relative;
            width: 100%;
            padding: 28px;
            border-radius: 24px;
            background: var(--cream);
            box-shadow: 0 30px 70px -20px rgba(0, 0, 0, .55);
            overflow: hidden;
        }
        .card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 5px;
            background: linear-gradient(90deg, var(--coral) 0 25%, var(--amber) 25% 50%, var(--teal) 50% 75%, var(--purple) 75% 100%);
        }
        .card h3 { font: bold 20px Georgia, serif; margin-bottom: 16px; color: var(--navy); }

        /* Tabel */
        .table-responsive { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { padding: 12px 14px; background: #efeae0; color: var(--navy); font-weight: bold; }
        td { padding: 14px; border-bottom: 1px solid #e8e2d5; color: var(--navy); }
        tr:hover td { background: rgba(0,0,0,.02); }

        .badge-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 12px;
        }
        .badge-dipinjam { background: rgba(119,85,239,.15); color: var(--purple); }
        .badge-terlambat { background: #ffe2dd; color: #c2412b; }

        @media(max-width: 768px) {
            .top-header { flex-direction: column; align-items: flex-start; }
            .hamburger-container { width: 100%; display: flex; justify-content: flex-end; }
        }
    </style>
</head>
<body>

    <div class="glow"></div>

    <div class="page">
        <!-- Header dengan Tombol Hamburger -->
        <div class="top-header">
            <div>
                <h1>Dashboard Admin</h1>
                <p>Selamat datang kembali di panel kontrol utama perpustakaan SIPUSTAKA</p>
            </div>
            
            <div class="hamburger-container">
                <button type="button" class="btn-hamburger" onclick="toggleMenu(event)">
                    ☰ Menu Utama
                </button>

                <!-- Dropdown Menu Sesuai Referensi Foto Kedua -->
                <div class="dropdown-menu-custom" id="dropdownMenu">
                    <div class="menu-section-title">Menu Utama</div>
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item active">🏠 Dashboard</a>
                    <a href="{{ route('admin.books.index') }}" class="dropdown-item">📚 Data Buku</a>
                    <a href="{{ route('admin.kategori.index') }}" class="dropdown-item">🏷️ Kategori</a>
                    <a href="{{ route('admin.anggota.index') }}" class="dropdown-item">👥 Anggota</a>

                    <div class="dropdown-divider"></div>
                    <div class="menu-section-title">Transaksi</div>
                    <a href="{{ route('admin.peminjaman.index') }}" class="dropdown-item">🔄 Peminjaman</a>
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
        </div>

        <!-- Kartu Statistik -->
        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Stok Buku</h4>
                <div class="number">{{ $totalBuku ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h4>Transaksi Aktif</h4>
                <div class="number">{{ $transaksiAktif ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h4>Buku Terlambat</h4>
                <div class="number" style="color: #c2412b;">{{ $bukuTerlambat ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h4>Total Anggota Siswa</h4>
                <div class="number">{{ $totalAnggota ?? 0 }}</div>
            </div>
        </div>

        <!-- Grid Aktivitas & Jatuh Tempo -->
        <div class="content-grid">
            <!-- Aktivitas Terbaru -->
            <div class="card">
                <h3>Aktivitas Peminjaman Terbaru</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aktivitasTerbaru as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->user->name ?? 'Siswa' }}</strong><br>
                                        <span style="font-size: 11px; color: var(--muted);">{{ $item->user->username ?? '-' }}</span>
                                    </td>
                                    <td>{{ $item->book->judul_buku ?? 'Buku' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge-status badge-dipinjam">{{ $item->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 30px; color: var(--muted);">Belum ada aktivitas peminjaman terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Buku Jatuh Tempo / Mendekati Tenggat -->
            <div class="card">
                <h3>Peringatan Jatuh Tempo & Terlambat</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Jatuh Tempo</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bukuJatuhTempo as $index => $item)
                                @php
                                    $isTerlambat = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->isPast();
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->user->name ?? 'Siswa' }}</strong><br>
                                        <span style="font-size: 11px; color: var(--muted);">{{ $item->user->username ?? '-' }}</span>
                                    </td>
                                    <td>{{ $item->book->judul_buku ?? 'Buku' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}</td>
                                    <td>
                                        @if($isTerlambat)
                                            <span class="badge-status badge-terlambat">Sudah Terlambat</span>
                                        @else
                                            <span class="badge-status" style="background: #fef3c7; color: #d97706;">Segera Jatuh Tempo</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 30px; color: var(--muted);">Tidak ada buku yang mendekati jatuh tempo atau terlambat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu(event) {
            event.stopPropagation();
            document.getElementById('dropdownMenu').classList.toggle('show');
        }

        // Tutup menu dropdown jika mengklik di luar area menu
        window.onclick = function(event) {
            let menu = document.getElementById('dropdownMenu');
            if (!event.target.matches('.btn-hamburger') && !event.target.closest('.dropdown-menu-custom')) {
                if (menu.classList.contains('show')) {
                    menu.classList.remove('show');
                }
            }
        }
    </script>
</body>
</html>