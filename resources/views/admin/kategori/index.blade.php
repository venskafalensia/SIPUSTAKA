<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - SIPUSTAKA</title>
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

        /* Dropdown Menu Hamburger - Diatur left: 0 agar terbuka ke kanan dan aman di layar HP */
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

        /* ================= STATS ROW ================= */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: var(--cream);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,.4);
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        .stat-card small { font-size: 12px; color: var(--muted); display: block; margin-bottom: 4px; }
        .stat-card strong { font-size: 24px; font-family: Georgia, serif; color: var(--navy); }
        .stat-icon {
            width: 42px; height: 42px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: bold;
        }

        /* ================= FILTER & KARTU TABEL ================= */

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
        .badge-gray { background: #e8e2d5; color: var(--muted); }

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

        .empty-row { text-align: center; padding: 40px; color: var(--muted); }

        /* FLASH NOTIFICATIONS */
        .flash { padding: 14px 18px; border-radius: 14px; margin-bottom: 20px; font-size: 13px; line-height: 1.6; }
        .flash-ok { background: #d1fae5; color: #065f46; }
        .flash-err { background: #ffe2dd; color: #c2412b; }

        /* MODAL */
        .modal-bg {
            position: fixed; inset: 0; z-index: 2000;
            display: none; align-items: center; justify-content: center;
            padding: 16px; background: rgba(25, 21, 47, .75); backdrop-filter: blur(4px);
        }
        .modal-bg.open { display: flex; }
        .modal {
            width: 100%; max-width: 480px; max-height: calc(100vh - 32px);
            overflow-y: auto; padding: 30px; border-radius: 24px;
            background: var(--cream); box-shadow: 0 30px 70px -20px rgba(0,0,0,.5);
            position: relative;
        }
        .modal::before {
            content: ""; position: absolute; inset: 0 0 auto 0; height: 5px;
            background: linear-gradient(90deg, var(--coral), var(--amber), var(--teal), var(--purple));
        }
        .modal h3 { margin-bottom: 15px; font: bold 20px Georgia, serif; color: var(--navy); }
        .modal label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: bold; color: var(--navy); }
        .modal input[type="text"], .modal textarea {
            width: 100%; padding: 12px 14px; border: 1px solid #ddd6cc;
            border-radius: 10px; background: #fffdfa; color: var(--navy); font-size: 14px;
            margin-bottom: 12px; outline: none;
        }
        .modal textarea { height: 90px; resize: vertical; }
        .hint { font-size: 11px; color: var(--muted); margin-bottom: 15px; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px; }
        .btn-cancel {
            padding: 10px 16px; border: 1px solid #ddd6cc; border-radius: 10px;
            background: #fffdfa; color: var(--navy); font-weight: bold; cursor: pointer;
        }

        @media (max-width: 768px) {
            .filter-form { flex-direction: column; align-items: stretch; }
            .search, .btn-filter { width: 100%; }
        }
    </style>
</head>
<body>

<div class="container-fluid">

    {{-- TOPBAR ATAS --}}
    <div class="topbar">
        <div class="welcome">
            <h1>Kategori</h1>
            <p>Kelola kategori untuk mengelompokkan buku SIPUSTAKA.</p>
        </div>

        <div class="topbar-right">
            <div class="header-actions">
                <!-- DROPDOWN MENU HAMBURGER INTERAKTIF -->
                <div class="dropdown-container">
                    <button type="button" class="btn-ghost" onclick="toggleMenu(event)">
                        ☰ Menu Utama
                    </button>

                    <div class="dropdown-menu-custom" id="dropdownMenu">
                        <div class="menu-section-title">Menu Utama</div>
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">🏠 Dashboard</a>
                        <a href="{{ route('admin.books.index') }}" class="dropdown-item">📚 Data Buku</a>
                        <a href="{{ route('admin.kategori.index') }}" class="dropdown-item active">🏷️ Kategori</a>
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

                <button type="button" class="btn-primary" onclick="openKategori()">+ Tambah Kategori</button>
            </div>

            <div class="avatar">BS</div>
        </div>
    </div>

    @if(session('success')) <div class="flash flash-ok">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="flash flash-err">{{ session('error') }}</div> @endif
    @if($errors->any()) <div class="flash flash-err">{{ $errors->first() }}</div> @endif

    <div class="stat-row">
        <div class="stat-card">
            <div><small>Total Kategori</small><strong>{{ $totalKategori }}</strong></div>
            <div class="stat-icon" style="background:#eee8ff;color:#6848df">◇</div>
        </div>
        <div class="stat-card">
            <div><small>Total Judul Buku</small><strong>{{ $totalBuku }}</strong></div>
            <div class="stat-icon" style="background:#def4ee;color:#148f7c">▣</div>
        </div>
    </div>

    <div class="card">
        <div class="page-header-title">
            <div>
                <h2>Kategori Buku</h2>
                <p>Menampilkan kategori yang tersedia di perpustakaan.</p>
            </div>
        </div>

        <div class="filter-card">
            <form action="{{ route('admin.kategori.index') }}" method="GET" class="filter-form">
                <input type="text" name="search" class="search" value="{{ request('search') }}" placeholder="Cari nama kategori...">
                <button type="submit" class="btn-filter">Cari</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>KATEGORI</th>
                        <th>DESKRIPSI</th>
                        <th>JUMLAH BUKU</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($kategoris as $k)
                    <tr>
                        <td>
                            <div class="book-title">{{ $k->nama }}</div>
                            <div class="book-author">ID: {{ $k->id }}</div>
                        </td>
                        <td>{{ $k->deskripsi ?: '—' }}</td>
                        <td>
                            <span class="badge {{ $k->books_count > 0 ? 'badge-stock' : 'badge-gray' }}">
                                {{ $k->books_count }} buku
                            </span>
                        </td>
                        <td>
                            <div class="action">
                                <button type="button" class="btn-small btn-edit"
                                        data-id="{{ $k->id }}"
                                        data-nama="{{ $k->nama }}"
                                        data-deskripsi="{{ $k->deskripsi }}"
                                        onclick="openKategori(this)">Edit</button>
                                <form action="{{ route('admin.kategori.destroy', $k->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-small btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-row">Belum ada kategori.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @include('admin.partials.pagination', ['paginator' => $kategoris, 'label' => 'kategori'])
    </div>

</div>

<div class="modal-bg" id="kategoriModal">
    <form class="modal" id="kategoriForm" method="POST">
        @csrf
        <span id="kategoriMethod"></span>
        <h3 id="kategoriTitle">Tambah Kategori</h3>

        <label for="kNama">Nama Kategori</label>
        <input type="text" name="nama" id="kNama" maxlength="100" required>

        <label for="kDeskripsi">Deskripsi (opsional)</label>
        <textarea name="deskripsi" id="kDeskripsi" maxlength="255"></textarea>
        <div class="hint" id="kHint"></div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeKategori()">Batal</button>
            <button type="submit" class="btn-primary">Simpan</button>
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

function openKategori(btn) {
    const k = btn ? btn.dataset : null;
    const form = document.getElementById('kategoriForm');
    form.reset();
    if (k) {
        form.action = "{{ url('admin/kategori') }}/" + k.id;
        document.getElementById('kategoriMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('kategoriTitle').textContent = 'Edit Kategori';
        document.getElementById('kNama').value = k.nama;
        document.getElementById('kDeskripsi').value = k.deskripsi || '';
        document.getElementById('kHint').textContent = 'Mengubah nama akan ikut mengubah kategori di semua buku terkait.';
    } else {
        form.action = "{{ route('admin.kategori.store') }}";
        document.getElementById('kategoriMethod').innerHTML = '';
        document.getElementById('kategoriTitle').textContent = 'Tambah Kategori';
        document.getElementById('kHint').textContent = '';
    }
    document.getElementById('kategoriModal').classList.add('open');
}
function closeKategori() { document.getElementById('kategoriModal').classList.remove('open'); }
</script>
</body>
</html>