<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#19152f">
    <title>Laporan - SIPUSTAKA</title>
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

        a { color: inherit; text-decoration: none; }

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
            max-width: 1100px;
            margin: 0 auto;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            color: #fff;
            flex-wrap: wrap;
            gap: 15px;
        }
        .top-header h1 { font: bold 28px Georgia, serif; }
        .top-header p { font-size: 13px; color: #c9c3de; margin-top: 4px; }

        .btn-group-header {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            border: 0;
            transition: transform .2s, background .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-primary-custom {
            background: var(--coral);
            color: #fff;
            box-shadow: 0 8px 20px -6px rgba(255, 102, 85, .6);
        }
        .btn-primary-custom:hover { background: #f25545; transform: translateY(-2px); }

        .btn-secondary-custom {
            background: rgba(255, 255, 255, .1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .2);
        }
        .btn-secondary-custom:hover { background: rgba(255, 255, 255, .2); }

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
            font-size: 14px;
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
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--cream);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,.4);
        }
        .stat-card h4 { font-size: 13px; color: var(--muted); margin-bottom: 6px; }
        .stat-card .number { font: bold 26px Georgia, serif; color: var(--navy); }

        /* Kartu Utama */
        .card {
            position: relative;
            width: 100%;
            padding: 28px;
            border-radius: 24px;
            background: var(--cream);
            box-shadow: 0 30px 70px -20px rgba(0, 0, 0, .55);
            overflow: hidden;
            margin-bottom: 30px;
        }
        .card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 5px;
            background: linear-gradient(90deg, var(--coral) 0 25%, var(--amber) 25% 50%, var(--teal) 50% 75%, var(--purple) 75% 100%);
        }

        /* Tabel */
        .table-responsive { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { padding: 12px 14px; background: #efeae0; color: var(--navy); font-weight: bold; }
        td { padding: 14px; border-bottom: 1px solid #e8e2d5; color: var(--navy); }
        tr:hover td { background: rgba(0,0,0,.02); }

        .pagination { margin-top: 20px; display: flex; gap: 5px; justify-content: flex-end; }

        /* ===== Status & denda ===== */
        .status-cell { display: flex; flex-direction: column; align-items: flex-start; gap: 6px; min-width: 190px; }
        .badge {
            display: inline-block;
            padding: 5px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }
        .badge-active { background: rgba(119, 85, 239, .15); color: var(--purple); }
        .badge-ok     { background: rgba(20, 170, 153, .15); color: #0f8a7b; }
        .badge-warn   { background: #fff0d6; color: #9a6500; }
        .badge-late   { background: #ffe2dd; color: #c2412b; }
        .badge-wait   { background: #eee8ff; color: #6848df; }
        .badge-gray   { background: #efeae0; color: var(--muted); }
        .denda {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: bold;
            color: #c2412b;
        }
        .denda::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--coral);
        }

        /* ===== Pagination ringkas ===== */
        .pager { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
        .pager-info { margin: 0; color: var(--muted); font-size: 12px; }
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
            color: var(--navy);
            font-size: 12px;
            font-weight: bold;
        }
        a.pager-btn:hover { border-color: var(--coral); color: var(--coral); }
        .pager-btn.active { background: var(--coral); border-color: var(--coral); color: #fff; }
        .pager-btn.disabled { opacity: .45; }
    </style>
</head>
<body>

    <div class="glow"></div>

    <div class="page">
        <!-- Header -->
        <div class="top-header">
            <div>
                <h1>Laporan Peminjaman</h1>
                <p>Ringkasan aktivitas peminjaman buku perpustakaan SIPUSTAKA</p>
            </div>
            <div class="btn-group-header">
                <button onclick="window.print()" class="btn-custom btn-primary-custom">Cetak Laporan</button>

                <!-- Tombol Hamburger Menu Utama -->
                <div class="hamburger-container">
                    <button type="button" class="btn-hamburger" onclick="toggleMenu(event)">
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
                        <a href="{{ route('admin.pengembalian.index') }}" class="dropdown-item">↩️ Pengembalian</a>
                        <a href="{{ route('admin.laporan.index') }}" class="dropdown-item active">📊 Laporan</a>

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
        </div>

        <!-- Kartu Statistik -->
        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Transaksi</h4>
                <div class="number">{{ $totalPeminjaman ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h4>Buku Sedang Dipinjam</h4>
                <div class="number">{{ $peminjamanAktif ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h4>Sudah Dikembalikan</h4>
                <div class="number">{{ $peminjamanSelesai ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h4>Terlambat</h4>
                <div class="number" style="color: #c2412b;">{{ $totalTerlambat ?? 0 }}</div>
            </div>
        </div>

        <!-- Tabel Laporan -->
        <div class="card">
            <h3 style="margin-bottom: 18px; font-family: Georgia, serif;">Riwayat & Status Peminjaman Buku</h3>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status & Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $index => $item)
                            @php
                                $tempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->startOfDay();
                                $sudahKembali = ! is_null($item->tanggal_kembali);
                                $selesai = ($sudahKembali
                                    ? \Carbon\Carbon::parse($item->tanggal_kembali)
                                    : \Carbon\Carbon::today())->startOfDay();

                                // Keterlambatan dihitung dalam hari penuh (sama dengan halaman Pengembalian)
                                $terlambatHari = $selesai->gt($tempo) ? (int) $tempo->diffInDays($selesai) : 0;
                                $totalDenda = $terlambatHari * \App\Http\Controllers\PengembalianController::DENDA_PER_HARI;
                            @endphp
                            <tr>
                                <td>{{ $peminjamans->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $item->user->name ?? 'Siswa' }}</strong><br>
                                    <span style="font-size: 11px; color: var(--muted);">{{ $item->user->username ?? '-' }}</span>
                                </td>
                                <td>{{ $item->book->judul_buku ?? 'Judul Buku' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}</td>
                                <td>
                                    <div class="status-cell">
                                        @if($item->status === 'Menunggu')
                                            <span class="badge badge-wait">Menunggu persetujuan</span>

                                        @elseif($item->status === 'Ditolak')
                                            <span class="badge badge-gray">Ditolak</span>

                                        @elseif(! $sudahKembali)
                                            @if($terlambatHari > 0)
                                                <span class="badge badge-late">Terlambat {{ $terlambatHari }} hari</span>
                                                <span class="denda">Denda berjalan Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
                                            @else
                                                <span class="badge badge-active">Dipinjam (Aktif)</span>
                                            @endif

                                        @else
                                            @if($terlambatHari > 0)
                                                <span class="badge badge-warn">Dikembalikan · Terlambat {{ $terlambatHari }} hari</span>
                                                <span class="denda">Denda Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
                                            @else
                                                <span class="badge badge-ok">Dikembalikan · Tepat waktu</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: var(--muted);">Belum ada data laporan peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px;">
                @if($peminjamans->hasPages())
                    @php
                        $halaman = $peminjamans->currentPage();
                        $terakhir = $peminjamans->lastPage();
                        $rentang = $peminjamans->getUrlRange(max(1, $halaman - 2), min($terakhir, $halaman + 2));
                    @endphp

                    <nav class="pager" aria-label="Navigasi halaman">
                        <p class="pager-info">
                            Menampilkan {{ $peminjamans->firstItem() }} - {{ $peminjamans->lastItem() }}
                            dari {{ $peminjamans->total() }} peminjaman
                        </p>

                        <div class="pager-links">
                            @if($peminjamans->onFirstPage())
                                <span class="pager-btn disabled">‹ Sebelumnya</span>
                            @else
                                <a class="pager-btn" href="{{ $peminjamans->previousPageUrl() }}">‹ Sebelumnya</a>
                            @endif

                            @foreach($rentang as $nomor => $url)
                                @if($nomor === $halaman)
                                    <span class="pager-btn active">{{ $nomor }}</span>
                                @else
                                    <a class="pager-btn" href="{{ $url }}">{{ $nomor }}</a>
                                @endif
                            @endforeach

                            @if($peminjamans->hasMorePages())
                                <a class="pager-btn" href="{{ $peminjamans->nextPageUrl() }}">Berikutnya ›</a>
                            @else
                                <span class="pager-btn disabled">Berikutnya ›</span>
                            @endif
                        </div>
                    </nav>
                @endif
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
            if (menu && !event.target.closest('.hamburger-container')) {
                if (menu.classList.contains('show')) {
                    menu.classList.remove('show');
                }
            }
        }
    </script>
</body>
</html>