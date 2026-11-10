@extends('admin.partials.style')

@section('title', 'Tambah Buku - SIPUSTAKA')

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

    /* Topbar styling */
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
        background: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, .1);
        padding-bottom: 20px;
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
        right: 0;
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

    .breadcrumb {
        color: var(--muted);
        font-size: 13px;
        margin-bottom: 18px;
    }

    .breadcrumb span {
        color: var(--navy);
        font-weight: bold;
    }

    .form-header {
        margin-bottom: 20px;
        border-bottom: 1px solid #e8e2d5;
        padding-bottom: 15px;
    }

    .form-header h2 {
        font-family: Georgia, serif;
        font-size: 20px;
        margin-bottom: 4px;
        color: var(--navy);
    }

    .form-header p {
        color: var(--muted);
        font-size: 13px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    label {
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 8px;
        color: var(--navy);
    }

    input,
    select,
    textarea {
        width: 100%;
        border: 1px solid #ddd6cc;
        border-radius: 10px;
        padding: 12px 13px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        outline: none;
        background: #fffdfa;
        color: var(--navy);
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: var(--purple);
        box-shadow: 0 0 0 3px rgba(119,85,239,.15);
    }

    textarea {
        min-height: 110px;
        resize: vertical;
    }

    .error {
        color: #c2412b;
        font-size: 11px;
        margin-top: 6px;
    }

    .form-footer {
        border-top: 1px solid #e8e2d5;
        margin-top: 25px;
        padding-top: 18px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn {
        padding: 11px 20px;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-cancel {
        border: 1px solid #ddd6cc;
        background: white;
        color: #55505e;
    }
    .btn-cancel:hover { background: #efeae0; }

    .btn-save {
        border: none;
        background: var(--coral);
        color: white;
    }

    .btn-save:hover {
        opacity: .9;
    }

    @media (max-width: 800px) {
        .form-grid {
            grid-template-columns: 1-fr;
        }
        .form-group.full {
            grid-column: auto;
        }
    }
</style>

<div class="container-fluid">
    {{-- Topbar dengan Menu Hamburger & Avatar --}}
    <div class="topbar">
        <div class="welcome">
            <h1>Tambah Buku</h1>
            <p>Tambahkan buku baru ke katalog SIPUSTAKA.</p>
        </div>

        <div class="topbar-right">
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

            <div class="avatar">
                {{ strtoupper(mb_substr(auth()->user()->name ?? 'BS', 0, 2)) }}
            </div>
        </div>
    </div>

    {{-- Kartu Konten Utama Full-Width Landscape --}}
    <div class="main-card-container">
        <div class="breadcrumb">
            Data Buku / <span>Tambah Buku Baru</span>
        </div>

        <div class="form-header">
            <h2>Detail Buku</h2>
            <p>Lengkapi data buku dengan benar sebelum disimpan ke katalog.</p>
        </div>

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                {{-- SAMPUL BUKU --}}
                <div class="form-group full">
                    <label for="sampul">Foto Sampul Buku</label>

                    <input
                        type="file"
                        id="sampul"
                        name="sampul"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <small style="color:var(--muted);margin-top:6px">
                        Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                    </small>

                    @error('sampul')
                        <div class="error">{{ $message }}</div>
                    @enderror

                    <img
                        id="preview-sampul"
                        src="#"
                        alt="Preview sampul buku"
                        style="display:none;width:150px;height:210px;object-fit:cover;margin-top:12px;border-radius:10px;border:1px solid #ddd"
                    >
                </div>

                {{-- JUDUL --}}
                <div class="form-group">
                    <label for="judul_buku">Judul Buku</label>
                    <input
                        type="text"
                        id="judul_buku"
                        name="judul_buku"
                        value="{{ old('judul_buku') }}"
                        placeholder="Contoh: Pemrograman Web dengan Laravel"
                        required
                    >
                    @error('judul_buku')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PENGARANG --}}
                <div class="form-group">
                    <label for="pengarang">Pengarang</label>
                    <input
                        type="text"
                        id="pengarang"
                        name="pengarang"
                        value="{{ old('pengarang') }}"
                        placeholder="Contoh: Budi Santoso"
                        required
                    >
                    @error('pengarang')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PENERBIT --}}
                <div class="form-group">
                    <label for="penerbit">Penerbit</label>
                    <input
                        type="text"
                        id="penerbit"
                        name="penerbit"
                        required
                        value="{{ old('penerbit') }}"
                        placeholder="Contoh: Informatika Bandung"
                    >
                    @error('penerbit')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ISBN --}}
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input
                        type="text"
                        id="isbn"
                        name="isbn"
                        required
                        value="{{ old('isbn') }}"
                        placeholder="Contoh: 9786021234567"
                    >
                    @error('isbn')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KATEGORI --}}
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required>
                        <option value="">Pilih kategori buku</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori }}" @selected(old('kategori') == $kategori)>{{ $kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TAHUN --}}
                <div class="form-group">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input
                        type="number"
                        id="tahun_terbit"
                        name="tahun_terbit"
                        required
                        value="{{ old('tahun_terbit') }}"
                        placeholder="2026"
                        min="1901"
                        max="{{ date('Y') }}"
                    >
                    @error('tahun_terbit')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- STOK --}}
                <div class="form-group">
                    <label for="stok">Jumlah Stok</label>
                    <input
                        type="number"
                        id="stok"
                        name="stok"
                        value="{{ old('stok', 1) }}"
                        min="0"
                        required
                    >
                    @error('stok')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- DESKRIPSI --}}
                <div class="form-group full">
                    <label for="deskripsi">Deskripsi Singkat</label>
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        placeholder="Tuliskan ringkasan singkat isi buku..."
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.books.index') }}" class="btn btn-cancel">
                    Batal
                </a>
                <button type="submit" class="btn btn-save">
                    Simpan Buku
                </button>
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
        if (menu && !event.target.closest('.dropdown-container')) {
            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
            }
        }
    }

    document.getElementById('sampul').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-sampul');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endsection