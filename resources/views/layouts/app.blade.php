<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIPUSTAKA')</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- CSS SIPUSTAKA -->
    <link
        rel="stylesheet"
        href="{{ asset('css/sipustaka.css') }}"
    >

</head>


<body>

<div class="app">


    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <div class="logo">

            <div class="logo-icon">
                S
            </div>

            <div>
                <h2>SIPUSTAKA</h2>
                <span>Perpustakaan Sekolah</span>
            </div>

        </div>


        <div class="menu-title">
            MENU UTAMA
        </div>


        <nav class="sidebar-menu">

            <a href="{{ url('/') }}" class="menu-item active">

                <span class="menu-icon">⌂</span>

                <span>
                    Dashboard
                </span>

            </a>


            <a href="#" class="menu-item">

                <span class="menu-icon">▣</span>

                <span>
                    Data Buku
                </span>

            </a>


            <a href="#" class="menu-item">

                <span class="menu-icon">▤</span>

                <span>
                    Kategori
                </span>

            </a>


            <a href="#" class="menu-item">

                <span class="menu-icon">♙</span>

                <span>
                    Anggota
                </span>

            </a>


            <a href="#" class="menu-item">

                <span class="menu-icon">⇄</span>

                <span>
                    Peminjaman
                </span>

            </a>


            <a href="#" class="menu-item">

                <span class="menu-icon">↩</span>

                <span>
                    Pengembalian
                </span>

            </a>


            <a href="#" class="menu-item">

                <span class="menu-icon">▥</span>

                <span>
                    Laporan
                </span>

            </a>

        </nav>


        <div class="sidebar-bottom">

            <a href="#" class="menu-item">

                <span class="menu-icon">⚙</span>

                <span>
                    Pengaturan
                </span>

            </a>


            <a href="#" class="menu-item logout">

                <span class="menu-icon">↪</span>

                <span>
                    Keluar
                </span>

            </a>

        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>



    <!-- ================= MAIN ================= -->

    <main class="main-content">


        <!-- TOPBAR -->

            <header class="topbar">

            <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Buka menu">
                ☰
            </button>

            <div class="search-box">
                <span>⌕</span>
                <input type="text" placeholder="Cari buku atau anggota...">
            </div>


            <div class="topbar-right">


                <button class="notification">

                    ♧

                    <span></span>

                </button>



                <div class="profile">


                    <div class="avatar">
                        BS
                    </div>


                    <div class="profile-info">

                        <strong>
                            Bu Sari
                        </strong>

                        <small>
                            Admin / Pustakawan
                        </small>

                    </div>


                    <span class="arrow">
                        ⌄
                    </span>

                </div>


            </div>


        </header>



        <!-- PAGE CONTENT -->

        <section class="page-content">

            <!-- Contoh Wrapper Header Halaman yang Diperbaiki (Gunakan struktur ini di view konten Anda) -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    @yield('page-title')
                </div>

                <!-- Bagian Tombol / Menu Utama di sebelah kanan agar tidak menumpuk ke atas -->
                <div class="flex items-center gap-3 self-end md:self-auto relative">
                    <!-- Tambahkan id/class dropdown menu di sini jika diperlukan -->
                </div>
            </div>

            @yield('content')

        </section>


    </main>


</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if (!menuBtn || !sidebar || !overlay) return;

    menuBtn.addEventListener('click', function () {
        sidebar.classList.toggle('mobile-open');
        overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', function () {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
    });

    sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });
    });
});
</script>

</body>
</html>