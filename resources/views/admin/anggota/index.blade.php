<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#19152f">
    <title>Manajemen Anggota - SIPUSTAKA</title>
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
            max-width: 1050px;
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
            position: relative;
        }
        .top-header h1 { font: bold 28px Georgia, serif; }
        .top-header p { font-size: 13px; color: #c9c3de; margin-top: 4px; }

        .btn-group-header {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn-custom {
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 13px;
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

        .btn-teal-custom {
            background: var(--teal);
            color: #fff;
        }
        .btn-teal-custom:hover { background: #119688; transform: translateY(-2px); }

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
            font-size: 13px;
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

        .alert-box {
            margin-bottom: 20px;
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 13px;
            line-height: 1.5;
        }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger { background: #ffe2dd; color: #c2412b; }

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

        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .search-input {
            flex: 1;
            height: 46px;
            padding: 0 16px;
            border: 1px solid #ddd6cc;
            border-radius: 12px;
            background: #fffdfa;
            color: var(--navy);
            outline: none;
            font-size: 14px;
        }
        .search-input:focus { border-color: var(--purple); box-shadow: 0 0 0 4px rgba(119, 85, 239, .15); }

        .table-responsive { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { padding: 12px 14px; background: #efeae0; color: var(--navy); font-weight: bold; }
        td { padding: 14px; border-bottom: 1px solid #e8e2d5; color: var(--navy); }
        tr:hover td { background: rgba(0,0,0,.02); }

        .badge-siswa {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 8px;
            background: rgba(20, 170, 153, .15);
            color: var(--teal);
            font-weight: bold;
            font-size: 12px;
        }

        .btn-delete {
            background: #ffe2dd;
            color: #c2412b;
            border: 0;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-delete:hover { background: #fcd3c9; }

        .modal-backdrop {
            position: fixed; inset: 0; background: rgba(25, 21, 47, .75);
            -webkit-backdrop-filter: blur(4px); backdrop-filter: blur(4px);
            display: none; align-items: center; justify-content: center; z-index: 100;
            padding: 20px;
        }
        .modal-backdrop.show { display: flex; }
        .modal-card {
            position: relative; width: 100%; max-width: 480px;
            background: var(--cream); border-radius: 24px; padding: 30px;
            box-shadow: 0 30px 70px -20px rgba(0,0,0,.5);
            animation: rise .3s cubic-bezier(.2, .7, .2, 1);
            overflow: hidden;
        }
        .modal-card::before {
            content: ""; position: absolute; inset: 0 0 auto 0; height: 5px;
            background: linear-gradient(90deg, var(--coral), var(--amber), var(--teal), var(--purple));
        }
        @keyframes rise {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: none; }
        }

        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .modal-header h3 { font: bold 20px Georgia, serif; }
        .close-btn { background: none; border: 0; font-size: 20px; cursor: pointer; color: var(--muted); }
        .close-btn:hover { color: var(--navy); }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: bold; }
        .form-control {
            width: 100%; height: 48px; padding: 10px 16px;
            border: 1px solid #ddd6cc; border-radius: 12px;
            background: #fffdfa; color: var(--navy); font-size: 14px; outline: none;
        }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px; }

        @media(max-width: 650px) {
            .top-header { flex-direction: column; align-items: flex-start; }
            .btn-group-header { width: 100%; flex-wrap: wrap; }
        }
    </style>
</head>
<body>

    <div class="glow"></div>

    <div class="page">
        <!-- Header -->
        <div class="top-header">
            <div>
                <h1>Manajemen Anggota</h1>
                <p>Kelola dan backup data siswa perpustakaan SMK Negeri 5 Surakarta</p>
            </div>
            <div class="btn-group-header">
                <a href="{{ route('admin.anggota.export') }}" class="btn-custom btn-teal-custom">↓ Export CSV</a>
                <button type="button" class="btn-custom btn-secondary-custom" style="color:var(--navy); background:#efeae0; border-color:#ddd6cc;" onclick="openImportModal()">↑ Import CSV</button>
                <button type="button" class="btn-custom btn-primary-custom" onclick="openModal()">+ Tambah Siswa Baru</button>

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
                        <a href="{{ route('admin.anggota.index') }}" class="dropdown-item active">👥 Anggota</a>

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
        </div>

        <!-- Alert -->
        @if(session('success'))
            <div class="alert-box alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-box alert-danger">
                <ul style="padding-left: 15px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card & Tabel -->
        <div class="card">
            <form action="{{ route('admin.anggota.index') }}" method="GET" class="search-form">
                <input type="text" name="search" class="search-input" value="{{ request('search') }}" placeholder="Cari nama, NISN/username, atau email...">
                <button type="submit" class="btn-custom btn-primary-custom" style="height: 46px;">Cari</button>
            </form>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>NISN / Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggotas as $index => $anggota)
                            <tr>
                                <td>{{ $anggotas->firstItem() + $index }}</td>
                                <td style="font-weight: bold;">{{ $anggota->name }}</td>
                                <td>{{ $anggota->username }}</td>
                                <td>{{ $anggota->email }}</td>
                                <td><span class="badge-siswa">Siswa</span></td>
                                <td>
                                    <form action="{{ route('admin.anggota.destroy', $anggota->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: var(--muted);">Belum ada data siswa yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 20px;">
                {{ $anggotas->links() }}
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH SISWA -->
    <div class="modal-backdrop" id="tambahModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3>Tambah Siswa Baru</h3>
                <button type="button" class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <form action="{{ route('admin.anggota.store') }}" method="POST">
                @csrf
                <p style="font-size: 13px; color: var(--muted); margin-bottom: 16px;">
                    Form ini digunakan admin untuk mendaftarkan siswa yang datang langsung ke perpustakaan.
                </p>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required>
                </div>

                <div class="form-group">
                    <label>NISN / Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Contoh: 0091234567" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Contoh: budi@student.com" required>
                </div>

                <div class="form-group">
                    <label>Kata Sandi Default</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-custom btn-secondary-custom" style="color: var(--navy); border-color: #ddd6cc;" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-custom btn-primary-custom">Simpan Data Siswa</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL IMPORT CSV -->
    <div class="modal-backdrop" id="importModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3>Import Data Anggota (CSV)</h3>
                <button type="button" class="close-btn" onclick="closeImportModal()">&times;</button>
            </div>
            <form action="{{ route('admin.anggota.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <p style="font-size: 13px; color: var(--muted); margin-bottom: 16px;">
                    Unggah file CSV berisi data siswa dengan format kolom: <b>name, username, email</b>. Password default siswa hasil import adalah <code style="color:var(--purple);">password123</code>.
                </p>

                <div class="form-group">
                    <label>Pilih File CSV</label>
                    <input type="file" name="file" class="form-control" accept=".csv, .txt" required style="padding-top: 10px;">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-custom btn-secondary-custom" style="color: var(--navy); border-color: #ddd6cc;" onclick="closeImportModal()">Batal</button>
                    <button type="submit" class="btn-custom btn-teal-custom">Upload & Import</button>
                </div>
            </form>
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

            let tambahModal = document.getElementById('tambahModal');
            let importModal = document.getElementById('importModal');
            if (event.target === tambahModal) closeModal();
            if (event.target === importModal) closeImportModal();
        }

        function openModal() { document.getElementById('tambahModal').classList.add('show'); }
        function closeModal() { document.getElementById('tambahModal').classList.remove('show'); }

        function openImportModal() { document.getElementById('importModal').classList.add('show'); }
        function closeImportModal() { document.getElementById('importModal').classList.remove('show'); }
    </script>
</body>
</html>