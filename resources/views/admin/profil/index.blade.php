<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - SIPUSTAKA</title>
    @include('admin.partials.style')
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
            padding: 30px 20px;
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

        /* ===== HERO PROFIL ===== */
        .profile-hero {
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, #19152f 0%, #2a2150 100%);
            border-radius: 18px; padding: 32px; color: white;
            display: flex; align-items: center; gap: 24px; margin-bottom: 22px;
        }
        .profile-hero::before {
            content: ""; position: absolute; width: 280px; height: 280px; border-radius: 50%;
            right: -70px; top: -110px; background: radial-gradient(circle, rgba(255,102,85,.45), transparent 70%);
        }
        .profile-hero::after {
            content: ""; position: absolute; width: 220px; height: 220px; border-radius: 50%;
            left: -60px; bottom: -120px; background: radial-gradient(circle, rgba(20,170,153,.35), transparent 70%);
        }
        .hero-avatar {
            position: relative; z-index: 1; flex-shrink: 0;
            width: 92px; height: 92px; border-radius: 50%;
            background: #ff6655; color: white; font-family: Georgia, serif; font-size: 34px; font-weight: bold;
            display: flex; align-items: center; justify-content: center;
            border: 4px solid rgba(255,255,255,.18); box-shadow: 0 8px 24px rgba(0,0,0,.25);
        }
        .hero-info { position: relative; z-index: 1; min-width: 0; }
        .hero-info h2 { font-family: Georgia, serif; font-size: 27px; margin-bottom: 6px; }
        .hero-info p { color: #c9c3e0; font-size: 14px; margin-bottom: 14px; word-break: break-all; }
        .hero-badges { display: flex; flex-wrap: wrap; gap: 8px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 999px; font-size: 11px; font-weight: bold;
            background: rgba(255,255,255,.12); color: #efeaff;
        }
        .hero-badge.green { background: rgba(20,170,153,.25); color: #7ff0dc; }
        .hero-badge i { width: 7px; height: 7px; border-radius: 50%; background: currentColor; display: inline-block; }
        .hero-bars { position: absolute; z-index: 1; right: 34px; bottom: 0; display: flex; align-items: flex-end; gap: 8px; opacity: .9; }
        .hero-bars span { display: block; width: 14px; border-radius: 6px 6px 0 0; }
        .hero-bars span:nth-child(1){height:44px;background:#ff6655}
        .hero-bars span:nth-child(2){height:70px;background:#f6a52e}
        .hero-bars span:nth-child(3){height:30px;background:#14aa99}
        .hero-bars span:nth-child(4){height:88px;background:#7755ef}
        .hero-bars span:nth-child(5){height:52px;background:#ff8a7a}

        /* ===== KARTU FORM ===== */
        .profile-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 20px; align-items: start; }
        .panel { background: #efeae0; border: 1px solid #ddd6cc; border-radius: 18px; overflow: hidden; }
        .panel-head { padding: 20px 24px; border-bottom: 1px solid #e8e2d5; display: flex; gap: 14px; align-items: center; }
        .panel-icon { width: 40px; height: 40px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .panel-head h3 { font-family: Georgia, serif; font-size: 16px; margin-bottom: 3px; color: var(--navy); }
        .panel-head p { color: var(--muted); font-size: 12px; }
        .panel-body { padding: 24px; }
        .form-group { margin-bottom: 18px; }
        .form-group:last-child { margin-bottom: 0; }
        .form-group label { display: block; font-size: 13px; font-weight: bold; margin-bottom: 8px; color: var(--navy); }
        .field { position: relative; }
        .field input {
            width: 100%; border: 1px solid #ddd6cc; border-radius: 10px; padding: 12px 13px;
            font-family: Arial, Helvetica, sans-serif; font-size: 13px; outline: none; background: #fffdfa; color: var(--navy);
        }
        .field input:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgba(119,85,239,.15); }
        .field input[readonly] { background: #f6f2ea; color: var(--muted); cursor: not-allowed; }
        .field .toggle {
            position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
            border: none; background: transparent; cursor: pointer; color: var(--muted); font-size: 11px; font-weight: bold; padding: 4px 6px;
        }
        .field .toggle:hover { color: var(--purple); }
        .field.has-toggle input { padding-right: 58px; }
        .error { color: #c2412b; font-size: 11px; margin-top: 6px; }
        .hint { color: var(--muted); font-size: 11px; margin-top: 6px; }
        .panel-foot { padding: 16px 24px; border-top: 1px solid #e8e2d5; background: #e8e2d5; display: flex; justify-content: flex-end; }
        .tips { margin-top: 20px; background: #fef3c7; border: 1px solid #fde68a; border-radius: 12px; padding: 16px 18px; font-size: 12px; color: #92400e; line-height: 1.7; }
        .tips strong { display: block; margin-bottom: 4px; font-size: 13px; }
        .section-gap { margin-bottom: 22px; }
        .section-title { font-family: Georgia, serif; font-size: 18px; margin-bottom: 12px; color: #fff; }

        @media (max-width: 1000px) { .profile-grid { grid-template-columns: 1fr; } .hero-bars { display: none; } }
        @media (max-width: 600px) { .profile-hero { flex-direction: column; text-align: center; padding: 26px 18px; } .hero-badges { justify-content: center; } }
    </style>
</head>
<body>
<div class="container-fluid">

    <div class="topbar">
        <div class="welcome">
            <h1>Profil</h1>
            <p>Kelola informasi akun dan keamanan kata sandimu.</p>
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
                    <a href="{{ route('admin.pengembalian.index') }}" class="dropdown-item">↩️ Pengembalian</a>
                    <a href="{{ route('admin.laporan.index') }}" class="dropdown-item">📊 Laporan</a>

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.profil.index') }}" class="dropdown-item active">⚙️ Profil</a>
                    
                    <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                        @csrf
                        <button type="submit" class="dropdown-item" style="width: 100%; background: none; border: 0; text-align: left; color: #c2412b; cursor: pointer;">
                            🚪 Keluar
                        </button>
                    </form>
                </div>
            </div>

            <div class="avatar">{{ strtoupper(mb_substr($user->name, 0, 2)) }}</div>
        </div>
    </div>

    <div class="main-card-container">

        @if(session('success')) <div class="flash flash-ok">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="flash flash-err">{{ session('error') }}</div> @endif

        {{-- HERO --}}
        <div class="profile-hero">
            <div class="hero-avatar">{{ strtoupper(mb_substr($user->name, 0, 2)) }}</div>

            <div class="hero-info">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
                <div class="hero-badges">
                    <span class="hero-badge">♙ {{ ucfirst($user->role ?? 'admin') }}</span>
                    <span class="hero-badge">@ {{ $user->username ?? '-' }}</span>
                    <span class="hero-badge green"><i></i> Akun aktif</span>
                    @if($user->created_at)
                        <span class="hero-badge">Bergabung {{ $user->created_at->format('d M Y') }}</span>
                    @endif
                </div>
            </div>

            <div class="hero-bars"><span></span><span></span><span></span><span></span><span></span></div>
        </div>

        {{-- RINGKASAN --}}
        <div class="section-title" style="color: var(--navy);">Ringkasan Perpustakaan</div>
        <div class="stat-row section-gap">
            <div class="stat-card">
                <div><small>Total Judul Buku</small><strong>{{ $totalBuku }}</strong></div>
                <div class="stat-icon" style="background:#eee8ff;color:#6848df">▣</div>
            </div>
            <div class="stat-card">
                <div><small>Total Anggota</small><strong>{{ $totalAnggota }}</strong></div>
                <div class="stat-icon" style="background:#fff0d6;color:#e59a1c">♙</div>
            </div>
            <div class="stat-card">
                <div><small>Peminjaman Aktif</small><strong>{{ $peminjamanAktif }}</strong></div>
                <div class="stat-icon" style="background:#e9e4ff;color:#7656e9">⇄</div>
            </div>
        </div>

        <div class="profile-grid">

            {{-- INFORMASI AKUN --}}
            <form class="panel" action="{{ route('admin.profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="panel-head">
                    <div class="panel-icon" style="background:#eee8ff;color:#6848df">♙</div>
                    <div>
                        <h3>Informasi Akun</h3>
                        <p>Perbarui nama, username, dan email.</p>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <div class="field">
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        @error('name') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="field">
                            <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                        </div>
                        @error('username') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="field">
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        @error('email') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label>Peran</label>
                        <div class="field">
                            <input type="text" value="{{ ucfirst($user->role ?? 'admin') }}" readonly>
                        </div>
                        <div class="hint">Peran akun tidak bisa diubah dari halaman ini.</div>
                    </div>
                </div>

                <div class="panel-foot">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>

            {{-- KATA SANDI --}}
            <div>
                <form class="panel" action="{{ route('admin.profil.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="panel-head">
                        <div class="panel-icon" style="background:#ffe2dd;color:#c2412b">⚿</div>
                        <div>
                            <h3>Ubah Kata Sandi</h3>
                            <p>Gunakan kata sandi yang sulit ditebak.</p>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="current_password">Kata Sandi Saat Ini</label>
                            <div class="field has-toggle">
                                <input type="password" id="current_password" name="current_password" required>
                                <button type="button" class="toggle" onclick="togglePass('current_password', this)">Lihat</button>
                            </div>
                            @error('current_password') <div class="error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Kata Sandi Baru</label>
                            <div class="field has-toggle">
                                <input type="password" id="password" name="password" minlength="6" required>
                                <button type="button" class="toggle" onclick="togglePass('password', this)">Lihat</button>
                            </div>
                            @error('password') <div class="error">{{ $message }}</div> @enderror
                            <div class="hint">Minimal 6 karakter.</div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Ulangi Kata Sandi Baru</label>
                            <div class="field has-toggle">
                                <input type="password" id="password_confirmation" name="password_confirmation" minlength="6" required>
                                <button type="button" class="toggle" onclick="togglePass('password_confirmation', this)">Lihat</button>
                            </div>
                        </div>
                    </div>

                    <div class="panel-foot">
                        <button type="submit" class="btn-primary">Ganti Kata Sandi</button>
                    </div>
                </form>

                <div class="tips">
                    <strong>Tips keamanan</strong>
                    Jangan membagikan kata sandi admin ke siapa pun, dan ganti secara berkala. Kalau memakai komputer bersama di ruang TU, selalu klik <b>Keluar</b> setelah selesai.
                </div>
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

function togglePass(id, btn) {
    const input = document.getElementById(id);
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.textContent = show ? 'Sembunyi' : 'Lihat';
}
</script>
</body>
</html>
```[cite: 12]