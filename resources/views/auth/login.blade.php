<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#19152f">

    <title>Login - SIPUSTAKA</title>

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
        }

        button, input { font: inherit; }
        a { color: inherit; text-decoration: none; }

        /* ===== Latar: cahaya warna + batang buku yang bergerak ===== */
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

        .bars {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            height: 170px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 14px;
            opacity: .35;
            pointer-events: none;
        }
        .bars span {
            width: 22px;
            border-radius: 8px 8px 0 0;
            transform-origin: bottom;
            animation: grow 4.8s ease-in-out infinite;
        }
        .bars span:nth-child(1) { height: 90px;  background: var(--coral);  animation-delay: 0s; }
        .bars span:nth-child(2) { height: 130px; background: var(--amber);  animation-delay: .5s; }
        .bars span:nth-child(3) { height: 70px;  background: var(--teal);   animation-delay: 1s; }
        .bars span:nth-child(4) { height: 160px; background: var(--purple); animation-delay: 1.5s; }
        .bars span:nth-child(5) { height: 100px; background: #e5806f;       animation-delay: 2s; }
        .bars span:nth-child(6) { height: 75px;  background: var(--teal);   animation-delay: 2.5s; }
        .bars span:nth-child(7) { height: 120px; background: var(--amber);  animation-delay: 3s; }

        @keyframes grow {
            0%, 100% { transform: scaleY(1); }
            50%      { transform: scaleY(.72); }
        }

        /* ===== Halaman ===== */
        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 26px 20px 22px;
        }

        .rise { animation: rise .7s cubic-bezier(.2, .7, .2, 1) backwards; animation-delay: var(--d, 0s); }
        @keyframes rise {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: none; }
        }

        /* Brand */
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
        }
        .brand-logo { display: flex; align-items: flex-end; gap: 3px; height: 28px; }
        .brand-logo span { display: block; width: 6px; border-radius: 3px; }
        .brand-logo span:nth-child(1) { height: 15px; background: var(--coral); }
        .brand-logo span:nth-child(2) { height: 23px; background: var(--amber); }
        .brand-logo span:nth-child(3) { height: 18px; background: var(--teal); }
        .brand-logo span:nth-child(4) { height: 27px; background: var(--purple); }
        .brand strong { font: bold 22px Georgia, serif; letter-spacing: .3px; }

        /* Judul */
        .hero {
            margin: 26px 0 24px;
            text-align: center;
            max-width: 620px;
            color: #fff;
        }
        .hero h1 {
            font: bold 31px/1.25 Georgia, serif;
        }
        .hero h1 em {
            font-style: normal;
            background: linear-gradient(90deg, var(--coral), var(--amber));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .hero p {
            margin-top: 12px;
            font-size: 14px;
            line-height: 1.7;
            color: #c9c3de;
        }

        /* ===== Kartu login ===== */
        .card {
            position: relative;
            width: 100%;
            max-width: 460px;
            padding: 34px 32px 26px;
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
            background: linear-gradient(90deg,
                var(--coral) 0 25%, var(--amber) 25% 50%,
                var(--teal) 50% 75%, var(--purple) 75% 100%);
        }

        .welcome { font-size: 13px; color: var(--muted); }
        .card h2 { margin: 4px 0 20px; font: bold 25px Georgia, serif; }

        .login-error {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #ffe2dd;
            color: #c2412b;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Tab tipe akun */
        .account-tabs {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding: 5px;
            margin-bottom: 22px;
            border-radius: 14px;
            background: #efeae0;
        }
        .tab-pill {
            position: absolute;
            top: 5px;
            bottom: 5px;
            left: 5px;
            width: calc(50% - 5px);
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(25, 21, 47, .12);
            transition: transform .3s cubic-bezier(.4, 0, .2, 1);
        }
        .account-tabs[data-active="admin"] .tab-pill { transform: translateX(100%); }
        .account-tab {
            position: relative;
            z-index: 1;
            padding: 12px 8px;
            border: 0;
            background: transparent;
            color: var(--muted);
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: color .2s;
        }
        .account-tab.active { color: var(--navy); }

        /* Form */
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: bold;
        }
        .input-wrapper { position: relative; }
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            color: #a49bbd;
            pointer-events: none;
            transition: color .2s;
        }
        .input-wrapper input {
            width: 100%;
            height: 52px;
            padding: 0 48px 0 46px;
            border: 1px solid #ddd6cc;
            border-radius: 13px;
            background: #fffdfa;
            color: var(--navy);
            font-size: 16px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-wrapper input::placeholder { color: #b5adc2; }
        .input-wrapper input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 4px rgba(119, 85, 239, .15);
        }
        .input-wrapper:focus-within .input-icon { color: var(--purple); }
        .input-wrapper input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 60px #fffdfa inset;
            -webkit-text-fill-color: var(--navy);
        }

        .password-toggle {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: #a49bbd;
            cursor: pointer;
        }
        .password-toggle:hover { color: var(--purple); background: #f1ecff; }

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 4px 0 22px;
            font-size: 13px;
        }
        .remember { display: flex; align-items: center; gap: 8px; color: #6f6877; cursor: pointer; }
        .remember input { width: 17px; height: 17px; accent-color: var(--coral); }
        .forgot-password { color: var(--coral); font-weight: bold; }
        .forgot-password:hover { text-decoration: underline; }

        .login-button {
            width: 100%;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 0;
            border-radius: 14px;
            background: var(--coral);
            color: #fff;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 10px 24px -8px rgba(255, 102, 85, .7);
            transition: transform .2s, box-shadow .2s, background .2s;
        }
        .login-button:hover {
            background: #f25545;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px -8px rgba(255, 102, 85, .8);
        }
        .login-button:active { transform: translateY(0); }
        .login-button:disabled { opacity: .7; cursor: wait; transform: none; }
        .login-button svg { transition: transform .2s; }
        .login-button:hover svg { transform: translateX(4px); }

        .login-help {
            margin-top: 18px;
            text-align: center;
            font-size: 12px;
            line-height: 1.6;
            color: var(--muted);
        }

        /* ===== Fitur (kartu bergantian menyala) ===== */
        .features-title {
            margin: 38px 0 14px;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #9d96b8;
            text-align: center;
        }
        .features {
            width: 100%;
            max-width: 980px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }
        .feature {
            position: relative;
            padding: 20px 18px;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 18px;
            background: rgba(255, 255, 255, .06);
            color: #fff;
            -webkit-backdrop-filter: blur(6px);
            backdrop-filter: blur(6px);
            transition: transform .35s ease, background .35s ease, border-color .35s ease, box-shadow .35s ease;
        }
        .feature .ic {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            margin-bottom: 14px;
            border-radius: 13px;
            background: var(--bg);
            color: var(--c);
        }
        .feature h3 { margin-bottom: 6px; font: bold 16px Georgia, serif; }
        .feature p { font-size: 12.5px; line-height: 1.6; color: #bdb6d3; }
        .feature:hover,
        .feature.on {
            transform: translateY(-6px);
            background: rgba(255, 255, 255, .11);
            border-color: var(--c);
            box-shadow: 0 16px 34px -14px var(--c);
        }

        .copyright {
            margin-top: auto;
            padding-top: 34px;
            font-size: 12px;
            color: #8f88aa;
            text-align: center;
        }

        /* ===== Tablet & HP ===== */
        @media (max-width: 860px) {
            .features { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 480px) {
            .page { padding: 20px 14px 18px; }
            .hero { margin: 20px 0 20px; }
            .hero h1 { font-size: 24px; }
            .hero p { font-size: 13px; }
            .card { padding: 28px 20px 22px; border-radius: 20px; }
            .card h2 { font-size: 22px; }
            .account-tab { font-size: 12px; padding: 12px 4px; }
            .login-options { flex-wrap: wrap; }
            .features { gap: 10px; }
            .feature { padding: 16px 14px; }
            .feature h3 { font-size: 14px; }
            .feature p { font-size: 12px; }
            .bars { height: 110px; gap: 9px; }
            .bars span { width: 14px; }
        }

        @media (max-width: 340px) {
            .features { grid-template-columns: 1fr; }
        }

        @media (prefers-reduced-motion: reduce) {
            .rise, .bars span { animation: none; }
            .feature, .tab-pill, .login-button { transition: none; }
        }
    </style>
</head>

<body>

    <div class="glow"></div>

    <div class="bars" aria-hidden="true">
        <span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span>
    </div>

    <div class="page">

        {{-- BRAND --}}
        <div class="brand rise">
            <div class="brand-logo">
                <span></span><span></span><span></span><span></span>
            </div>
            <strong>SIPUSTAKA</strong>
        </div>

        {{-- JUDUL --}}
        <div class="hero rise" style="--d:.08s">
            <h1>Satu pintu untuk semua urusan <em>pinjam-buku</em> sekolah.</h1>
            <p>
                Sistem milik Perpustakaan SMK Negeri 5 Surakarta —
                cari katalog, ajukan peminjaman, dan pantau denda dari satu tempat.
            </p>
        </div>


        {{-- KARTU LOGIN --}}
        <div class="card rise" style="--d:.16s">

            <p class="welcome">Selamat datang kembali</p>
            <h2>Masuk ke akun kamu</h2>

            {{-- PESAN ERROR LOGIN --}}
            @if(session('login_error'))
                <div class="login-error">
                    {{ session('login_error') }}
                </div>
            @endif

            {{-- PILIH TIPE AKUN --}}
            <div class="account-tabs" id="accountTabs" data-active="student">
                <span class="tab-pill"></span>

                <button type="button" class="account-tab active" id="studentTab"
                        onclick="selectAccount('student')">
                    Siswa 
                </button>

                <button type="button" class="account-tab" id="adminTab"
                        onclick="selectAccount('admin')">
                    Admin 
                </button>
            </div>

            {{-- FORM LOGIN --}}
            <form action="{{ route('login.process') }}" method="POST" id="loginForm">

                @csrf

                {{-- TIPE AKUN --}}
                <input type="hidden" name="account_type" id="accountType" value="student">

                {{-- USERNAME --}}
                <div class="form-group">
                    <label for="username">
                        <span id="usernameLabel">NISN / Username</span>
                    </label>

                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>
                            </svg>
                        </span>

                        <input type="text" id="username" name="username"
                               value="{{ old('username') }}"
                               placeholder="Contoh: 0091234567"
                               autocomplete="username" required>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <label for="password">Kata Sandi</label>

                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="11" width="16" height="10" rx="3"/>
                                <path d="M8 11V8a4 4 0 0 1 8 0v3"/>
                            </svg>
                        </span>

                        <input type="password" id="password" name="password"
                               placeholder="••••••••"
                               autocomplete="current-password" required>

                        <button type="button" class="password-toggle" id="passwordToggle"
                                onclick="togglePassword()" aria-label="Tampilkan kata sandi">
                            <svg id="eyeOn" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeOff" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 style="display:none">
                                <path d="M3 3l18 18"/>
                                <path d="M10.6 5.1A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a17 17 0 0 1-3.2 4.1M6.5 6.6C3.8 8.4 2 12 2 12s3.6 7 10 7c1.6 0 3-.4 4.3-1"/>
                                <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- OPTIONS --}}
                <div class="login-options">
                    <label class="remember">
                        <input type="checkbox" name="remember" value="1">
                        <span>Ingat saya</span>
                    </label>

                    <a href="#" class="forgot-password">Lupa kata sandi?</a>
                </div>

                {{-- BUTTON --}}
                <button type="submit" class="login-button" id="loginButton">
                    <span id="loginButtonText">Masuk</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                </button>

            </form>

            {{-- LINK DAFTAR MANDIRI (BARU) --}}
            <div style="margin-top: 16px; text-align: center; font-size: 13px; color: var(--muted);">
                Belum punya akun siswa? <a href="{{ route('register') }}" style="color: var(--purple); font-weight: bold;">Daftar mandiri di sini</a>
            </div>

           

        </div>


        {{-- FITUR --}}
        <p class="features-title rise" style="--d:.28s">Yang bisa kamu lakukan di SIPUSTAKA</p>

        <div class="features" id="features">

            <div class="feature rise" style="--d:.34s;--c:#7755ef;--bg:rgba(119,85,239,.2)">
                <div class="ic">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 5a2 2 0 0 1 2-2h12v16H6a2 2 0 0 0-2 2z"/>
                        <path d="M4 19V5M9 7h6M9 11h4"/>
                    </svg>
                </div>
                <h3>Katalog Buku</h3>
                <p>Jelajahi koleksi dan cek ketersediaan stok langsung dari HP.</p>
            </div>

            <div class="feature rise" style="--d:.42s;--c:#ff6655;--bg:rgba(255,102,85,.2)">
                <div class="ic">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 8h13l-3-3M20 16H7l3 3"/>
                    </svg>
                </div>
                <h3>Ajukan Peminjaman</h3>
                <p>Pinjam tanpa antre. Cukup ajukan, lalu tunggu persetujuan pustakawan.</p>
            </div>

            <div class="feature rise" style="--d:.5s;--c:#f6a52e;--bg:rgba(246,165,46,.2)">
                <div class="ic">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                </div>
                <h3>Pantau Denda</h3>
                <p>Lihat tenggat pengembalian agar terhindar dari keterlambatan.</p>
            </div>

            <div class="feature rise" style="--d:.58s;--c:#14aa99;--bg:rgba(20,170,153,.2)">
                <div class="ic">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                        <path d="M3 3v5h5M12 8v4l3 2"/>
                    </svg>
                </div>
                <h3>Riwayat Pinjam</h3>
                <p>Semua buku yang pernah kamu pinjam tercatat rapi di satu tempat.</p>
            </div>

        </div>

        <div class="copyright">
            © 2026 Perpustakaan SMK Negeri 5 Surakarta
        </div>

    </div>


    <script>

        // Tipe akun yang sedang dipilih
        let selectedAccount = 'student';


        // =========================
        // PILIH TIPE AKUN
        // =========================
        function selectAccount(account) {

            selectedAccount = account;

            const studentTab    = document.getElementById('studentTab');
            const adminTab      = document.getElementById('adminTab');
            const username      = document.getElementById('username');
            const usernameLabel = document.getElementById('usernameLabel');
            const accountType   = document.getElementById('accountType');
            const tabs          = document.getElementById('accountTabs');

            tabs.dataset.active = account;

            if (account === 'student') {

                // Tab siswa aktif
                studentTab.classList.add('active');
                adminTab.classList.remove('active');

                // Data yang dikirim ke Laravel
                accountType.value = 'student';

                // Label
                usernameLabel.textContent = 'NISN / Username';
                username.placeholder = 'Contoh: 0091234567';

            } else {

                // Tab admin aktif
                adminTab.classList.add('active');
                studentTab.classList.remove('active');

                // Data yang dikirim ke Laravel
                accountType.value = 'admin';

                // Label
                usernameLabel.textContent = 'Username';
                username.placeholder = 'Masukkan username admin';

            }

        }


        // =========================
        // TOGGLE PASSWORD
        // =========================
        function togglePassword() {

            const password = document.getElementById('password');
            const eyeOn    = document.getElementById('eyeOn');
            const eyeOff   = document.getElementById('eyeOff');
            const toggle   = document.getElementById('passwordToggle');

            const show = password.type === 'password';

            password.type = show ? 'text' : 'password';
            eyeOn.style.display  = show ? 'none' : '';
            eyeOff.style.display = show ? '' : 'none';
            toggle.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');

        }


        // =========================
        // TAB AKUN SETELAH LOGIN GAGAL
        // =========================
        selectAccount('{{ old('account_type') === 'admin' ? 'admin' : 'student' }}');


        // =========================
        // TOMBOL MASUK: CEGAH KLIK GANDA
        // =========================
        (function () {
            const form = document.getElementById('loginForm');
            const btn  = document.getElementById('loginButton');
            const text = document.getElementById('loginButtonText');

            form.addEventListener('submit', function () {
                btn.disabled = true;
                text.textContent = 'Memproses...';
            });

            // tombol "kembali" browser
            window.addEventListener('pageshow', function () {
                btn.disabled = false;
                text.textContent = 'Masuk';
            });
        })();


        // =========================
        // KARTU FITUR MENYALA BERGANTIAN
        // =========================
        (function () {
            const items = document.querySelectorAll('#features .feature');
            if (!items.length) return;
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            let i = 0;
            setInterval(function () {
                items.forEach(function (el) { el.classList.remove('on'); });
                items[i % items.length].classList.add('on');
                i++;
            }, 2800);
        })();

    </script>

</body>
</html>