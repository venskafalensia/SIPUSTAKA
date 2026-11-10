<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#19152f">
    <title>Daftar Akun - SIPUSTAKA</title>
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

        .glow {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background:
                radial-gradient(620px 440px at 88% -6%, rgba(255, 102, 85, .38), transparent 70%),
                radial-gradient(560px 460px at 4% 104%, rgba(20, 170, 153, .34), transparent 70%),
                radial-gradient(460px 340px at 50% 38%, rgba(119, 85, 239, .20), transparent 70%);
        }

        .page {
            position: relative; z-index: 1; min-height: 100vh;
            display: flex; flex-direction: column; align-items: center;
            padding: 30px 20px;
        }

        .brand { display: flex; align-items: center; gap: 12px; color: #fff; margin-bottom: 20px; }
        .brand-logo { display: flex; align-items: flex-end; gap: 3px; height: 28px; }
        .brand-logo span { display: block; width: 6px; border-radius: 3px; }
        .brand-logo span:nth-child(1) { height: 15px; background: var(--coral); }
        .brand-logo span:nth-child(2) { height: 23px; background: var(--amber); }
        .brand-logo span:nth-child(3) { height: 18px; background: var(--teal); }
        .brand-logo span:nth-child(4) { height: 27px; background: var(--purple); }
        .brand strong { font: bold 22px Georgia, serif; letter-spacing: .3px; }

        .card {
            position: relative; width: 100%; max-width: 460px;
            padding: 34px 32px 26px; border-radius: 24px;
            background: var(--cream);
            box-shadow: 0 30px 70px -20px rgba(0, 0, 0, .55);
        }
        .card::before {
            content: ""; position: absolute; inset: 0 0 auto 0; height: 5px;
            background: linear-gradient(90deg, var(--coral) 0 25%, var(--amber) 25% 50%, var(--teal) 50% 75%, var(--purple) 75% 100%);
        }

        .welcome { font-size: 13px; color: var(--muted); }
        .card h2 { margin: 4px 0 20px; font: bold 25px Georgia, serif; }

        .error-box {
            margin-bottom: 18px; padding: 12px 14px; border-radius: 12px;
            background: #ffe2dd; color: #c2412b; font-size: 13px; line-height: 1.5;
        }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: bold; }
        .input-wrapper input {
            width: 100%; height: 48px; padding: 0 16px;
            border: 1px solid #ddd6cc; border-radius: 12px;
            background: #fffdfa; color: var(--navy); font-size: 15px; outline: none;
        }
        .input-wrapper input:focus {
            border-color: var(--purple); box-shadow: 0 0 0 4px rgba(119, 85, 239, .15);
        }

        .submit-btn {
            width: 100%; height: 50px; margin-top: 10px; border: 0; border-radius: 14px;
            background: var(--coral); color: #fff; font-size: 15px; font-weight: bold; cursor: pointer;
            box-shadow: 0 10px 24px -8px rgba(255, 102, 85, .7);
        }
        .submit-btn:hover { background: #f25545; }

        .login-link {
            margin-top: 18px; text-align: center; font-size: 13px; color: var(--muted);
        }
        .login-link a { color: var(--purple); font-weight: bold; }
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="glow"></div>
    <div class="page">
        <div class="brand">
            <div class="brand-logo">
                <span></span><span></span><span></span><span></span>
            </div>
            <strong>SIPUSTAKA</strong>
        </div>

        <div class="card">
            <p class="welcome">Siswa Baru?</p>
            <h2>Buat Akun Mandiri</h2>

            @if ($errors->any())
                <div class="error-box">
                    <ul style="padding-left: 15px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>NISN / Username</label>
                    <div class="input-wrapper">
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: 0091234567" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="budi@student.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Kata Sandi</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Kata Sandi</label>
                    <div class="input-wrapper">
                        <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Daftar Sekarang</button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>
</html>