<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Buku - SIPUSTAKA</title>

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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--navy);
            color: #17142e;
            min-height: 100vh;
            padding: 30px;
        }

        a {
            text-decoration: none;
            color: inherit;
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
        }

        /* ================= TOPBAR ================= */

        .topbar {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 25px;
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

        /* ================= AKSI HEADER & HAMBURGER ================= */

        .header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
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

        .btn-primary {
            border: none;
            background: #ff6655;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 8px 20px -6px rgba(255, 102, 85, .6);
            transition: transform .2s, background .2s;
        }
        .btn-primary:hover {
            background: #f25545;
            transform: translateY(-2px);
        }

        /* Dropdown Menu Hamburger - Diatur left: 0 agar aman di layar HP */
        .dropdown-container {
            position: relative;
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

        /* ================= FILTER & KARTU TABEL MELEBAR ================= */

        .card {
            background: var(--cream);
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 30px 70px -25px rgba(0, 0, 0, .55);
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 5px;
            z-index: 1;
            background: linear-gradient(90deg,
                #ff6655 0 25%, #f6a52e 25% 50%,
                #14aa99 50% 75%, #7755ef 75% 100%);
        }

        .page-header-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .page-header-title h2 { font-family: Georgia, serif; font-size: 22px; color: var(--navy); }
        .page-header-title p { color: var(--muted); font-size: 13px; margin-top: 2px; }

        .filter-card {
            background: #efeae0;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .search {
            flex: 1;
            height: 44px;
            border: 1px solid #ddd6cc;
            border-radius: 10px;
            padding: 0 16px;
            outline: none;
            background: #fffdfa;
            color: var(--navy);
            font-size: 14px;
        }
        .search:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgba(119,85,239,.15); }

        .category {
            width: 220px;
            height: 44px;
            border: 1px solid #ddd6cc;
            border-radius: 10px;
            padding: 0 12px;
            background: #fffdfa;
            color: var(--navy);
            font-size: 14px;
            outline: none;
        }

        .btn-filter {
            height: 44px;
            padding: 0 22px;
            border: none;
            border-radius: 10px;
            background: var(--navy);
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        /* ================= TABLE ================= */

        .table-responsive { width: 100%; overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; text-align: left; }

        .table th {
            background: #efeae0;
            color: var(--navy);
            font-size: 12px;
            font-weight: bold;
            padding: 14px 16px;
        }

        .table td {
            padding: 15px 16px;
            font-size: 14px;
            border-bottom: 1px solid #e8e2d5;
            color: var(--navy);
        }
        .table tbody tr:hover td { background: rgba(0, 0, 0, .02); }

        .book-title { font-weight: bold; margin-bottom: 3px; }
        .book-author { color: var(--muted); font-size: 11px; }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-stock { background: rgba(20, 170, 153, .15); color: var(--teal); }
        .badge-empty { background: #ffe2dd; color: #c2412b; }

        .action { display: flex; gap: 8px; }
        .btn-small {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
        .btn-edit { background: #eee8ff; color: var(--purple); }
        .btn-delete { background: #ffe2dd; color: #c2412b; }

        /* PAGINATION */
        .pagination {
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .pagination-info { color: var(--muted); font-size: 13px; }
        .pagination-links { display: flex; gap: 6px; }
        .page {
            width: 34px; height: 34px;
            border: 1px solid #ddd6cc;
            border-radius: 8px;
            display: flex; justify-content: center; align-items: center;
            font-size: 13px; background: white; color: var(--navy);
        }
        .page.active { background: var(--coral); border-color: var(--coral); color: white; }

        /* NOTIFIKASI */
        .notice { padding: 14px 18px; border-radius: 14px; margin-bottom: 20px; font-size: 13px; line-height: 1.6; }
        .notice ul { margin: 6px 0 0 18px; }
        .notice-ok { background: #d1fae5; color: #065f46; }
        .notice-err { background: #ffe2dd; color: #c2412b; }
        .notice-warn { background: #fef3c7; color: #d97706; }

        /* ================= MODAL IMPORT CSV ================= */

        .modal-bg {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(25, 21, 47, .72);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
        .modal-bg.show { display: flex; }

        .modal-box {
            position: relative;
            width: 100%;
            max-width: 600px;
            max-height: calc(100vh - 32px);
            overflow-y: auto;
            padding: 34px 36px 30px;
            border-radius: 28px;
            background: var(--cream);
            box-shadow: 0 30px 70px -20px rgba(0, 0, 0, .55);
            animation: fadeIn .2s ease;
        }
        .modal-box::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 6px;
            background: linear-gradient(90deg,
                #ff6655 0 25%, #f6a52e 25% 50%,
                #14aa99 50% 75%, #7755ef 75% 100%);
        }

        .modal-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }
        .modal-head h3 {
            font: bold 24px Georgia, serif;
            color: var(--navy);
        }
        .modal-close {
            border: 0;
            background: transparent;
            color: var(--muted);
            font-size: 26px;
            line-height: 1;
            cursor: pointer;
            padding: 0 4px;
        }
        .modal-close:hover { color: var(--navy); }

        .modal-desc {
            color: var(--muted);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 22px;
        }
        .modal-desc strong { color: #5b5470; }
        .modal-desc code {
            font-family: Consolas, monospace;
            font-size: 13px;
            color: var(--purple);
        }

        .modal-label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .modal-file {
            width: 100%;
            padding: 16px;
            border: 1px solid #ddd6cc;
            border-radius: 16px;
            background: #fffdfa;
            color: var(--navy);
            font-size: 15px;
        }

        .modal-check {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 16px;
            font-size: 13px;
            line-height: 1.5;
            color: var(--navy);
            cursor: pointer;
        }
        .modal-check input {
            margin-top: 3px;
            accent-color: var(--coral);
        }

        .modal-tip {
            margin-top: 12px;
            font-size: 12px;
            line-height: 1.5;
            color: var(--muted);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 26px;
        }
        .btn-batal {
            padding: 13px 24px;
            border: 1px solid #ddd6cc;
            border-radius: 14px;
            background: #f3efe6;
            color: var(--navy);
            font: bold 15px Arial, Helvetica, sans-serif;
            cursor: pointer;
        }
        .btn-batal:hover { background: #e9e3d6; }
        .btn-upload {
            padding: 13px 24px;
            border: 0;
            border-radius: 14px;
            background: var(--teal);
            color: #fff;
            font: bold 15px Arial, Helvetica, sans-serif;
            cursor: pointer;
        }
        .btn-upload:hover { background: #0f9484; }
        .btn-upload:disabled { opacity: .7; cursor: wait; }

        @media (max-width: 768px) {
            .filter-form { flex-direction: column; align-items: stretch; }
            .search, .category, .btn-filter { width: 100%; }
            .modal-box { padding: 28px 22px 24px; }
            .modal-head h3 { font-size: 21px; }
        }
    </style>
</head>

<body>

<div class="container-fluid">

    {{-- TOPBAR ATAS --}}
    <div class="topbar">
        <div class="welcome">
            <h1>Data Buku</h1>
            <p>Kelola koleksi buku perpustakaan SIPUSTAKA</p>
        </div>

        <div class="topbar-right">
            <div class="header-actions">
                <a href="{{ route('admin.books.export') }}" class="btn-ghost">
                    ↓ Ekspor CSV
                </a>

                <button type="button" class="btn-ghost" onclick="openImport()">
                    ↑ Impor CSV
                </button>

                <!-- DROPDOWN MENU HAMBURGER INTERAKTIF -->
                <div class="dropdown-container">
                    <button type="button" class="btn-ghost" onclick="toggleMenu(event)">
                        ☰ Menu Utama
                    </button>

                    <div class="dropdown-menu-custom" id="dropdownMenu">
                        <div class="menu-section-title">Menu Utama</div>
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">🏠 Dashboard</a>
                        <a href="{{ route('admin.books.index') }}" class="dropdown-item active">📚 Data Buku</a>
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

                <a href="{{ route('admin.books.create') }}" class="btn-primary">
                    + Tambah Buku
                </a>
            </div>

            <div class="avatar">BS</div>
        </div>
    </div>

    {{-- PESAN NOTIFIKASI --}}
    @if(session('success'))
        <div class="notice notice-ok">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="notice notice-err">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="notice notice-err">{{ $errors->first() }}</div>
    @endif

    @if(session('import_errors'))
        <div class="notice notice-warn">
            <strong>Baris yang dilewati:</strong>
            <ul>
                @foreach(session('import_errors') as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- KARTU TABEL UTAMA (FULL-WIDTH MELEBAR) --}}
    <div class="card">
        
        <div class="page-header-title">
            <div>
                <h2>Koleksi Buku</h2>
                <p>Menampilkan data buku yang tersimpan di perpustakaan</p>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="filter-card">
            <form action="{{ route('admin.books.index') }}" method="GET" class="filter-form">
                <input
                    type="text"
                    name="search"
                    class="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul, pengarang, atau ISBN..."
                >

                <select name="kategori" class="category">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('kategori') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-filter">Cari</button>
            </form>
        </div>

        {{-- TABEL BUKU --}}
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>BUKU</th>
                        <th>PENGARANG</th>
                        <th>KATEGORI</th>
                        <th>TAHUN</th>
                        <th>STOK</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>
                            <div class="book-title">{{ $book->judul_buku }}</div>
                            <div class="book-author">ISBN: {{ $book->isbn }}</div>
                        </td>
                        <td>{{ $book->pengarang }}</td>
                        <td>{{ $book->kategori }}</td>
                        <td>{{ $book->tahun_terbit }}</td>
                        <td>
                            @if($book->stok > 0)
                                <span class="badge badge-stock">{{ $book->stok }} tersedia</span>
                            @else
                                <span class="badge badge-empty">Habis</span>
                            @endif
                        </td>
                        <td>
                            <div class="action">
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn-small btn-edit">Edit</a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-small btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px; color:var(--muted);">
                            Data buku belum tersedia.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINASI --}}
        <div class="pagination">
            <div class="pagination-info">
                Menampilkan {{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }} dari {{ $books->total() }} buku
            </div>

            <div class="pagination-links">
                @if($books->onFirstPage())
                    <span class="page">‹</span>
                @else
                    <a href="{{ $books->previousPageUrl() }}" class="page">‹</a>
                @endif

                <span class="page active">{{ $books->currentPage() }}</span>

                @if($books->hasMorePages())
                    <a href="{{ $books->nextPageUrl() }}" class="page">›</a>
                @else
                    <span class="page">›</span>
                @endif
            </div>
        </div>

    </div>

</div>

{{-- MODAL IMPORT DATA BUKU (CSV) --}}
<div class="modal-bg" id="importModal" onclick="if (event.target === this) closeImport()">
    <form class="modal-box"
          method="POST"
          action="{{ route('admin.books.import') }}"
          enctype="multipart/form-data"
          id="importForm">
        @csrf

        <div class="modal-head">
            <h3>Import Data Buku (CSV)</h3>
            <button type="button" class="modal-close" onclick="closeImport()" aria-label="Tutup">×</button>
        </div>

        <p class="modal-desc">
            Unggah file CSV hasil <strong>Ekspor</strong> dengan kolom wajib:
            <strong>judul_buku, isbn</strong>. Kolom lain: pengarang, penerbit,
            kategori, tahun_terbit, stok, deskripsi. Buku dengan ISBN yang sudah ada
            akan <code>dilewati</code>.
        </p>

        <label class="modal-label" for="importFile">Pilih File CSV</label>
        <input type="file"
               id="importFile"
               name="file"
               class="modal-file"
               accept=".csv,.txt,text/csv,text/plain"
               required>

        <label class="modal-check">
            <input type="checkbox" name="perbarui" value="1">
            <span>Perbarui juga buku yang ISBN-nya sudah ada (data lama ditimpa isi file)</span>
        </label>

        <p class="modal-tip">
            Tip: jangan membuka lalu menyimpan ulang file CSV memakai Excel, karena ISBN bisa
            berubah menjadi angka ilmiah. Cukup unggah file aslinya.
        </p>

        <div class="modal-actions">
            <button type="button" class="btn-batal" onclick="closeImport()">Batal</button>
            <button type="submit" class="btn-upload" id="importBtn">Upload &amp; Import</button>
        </div>
    </form>
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

    // ===== MODAL IMPORT CSV =====
    function openImport() {
        document.getElementById('importModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeImport() {
        document.getElementById('importModal').classList.remove('show');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeImport();
    });

    document.getElementById('importForm').addEventListener('submit', function () {
        var btn = document.getElementById('importBtn');
        btn.disabled = true;
        btn.textContent = 'Mengimpor...';
    });

    // tombol "kembali" browser: kembalikan tombol seperti semula
    window.addEventListener('pageshow', function () {
        var btn = document.getElementById('importBtn');
        btn.disabled = false;
        btn.innerHTML = 'Upload &amp; Import';
        closeImport();
    });
</script>

</body>

</html>