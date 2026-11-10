<aside class="sidebar" id="siswaSidebar">
    <div class="sidebar-head">
        <div class="brand">
            <span class="brand-mark">S</span>
            <span>SIPUSTAKA</span>
        </div>

        {{-- Tombol hamburger: hanya tampil di HP --}}
        <button type="button"
                class="hamburger-btn"
                id="hamburgerBtn"
                aria-label="Buka menu"
                aria-expanded="false"
                aria-controls="siswaMenu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <p class="menu-title">MENU SISWA</p>

    <nav class="menu" id="siswaMenu">
        <a href="{{ route('siswa.dashboard') }}"
           class="menu-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            <span class="menu-icon">⌂</span> Dashboard
        </a>

        <a href="{{ route('siswa.katalog.index') }}"
           class="menu-item {{ request()->routeIs('siswa.katalog.*') ? 'active' : '' }}">
            <span class="menu-icon">▤</span> Katalog Buku
        </a>

        <a href="{{ route('siswa.peminjaman.index') }}"
           class="menu-item {{ request()->routeIs('siswa.peminjaman.index') ? 'active' : '' }}">
            <span class="menu-icon">↗</span> Peminjaman Saya
        </a>

        <a href="{{ route('siswa.riwayat') }}"
           class="menu-item {{ request()->routeIs('siswa.riwayat') ? 'active' : '' }}">
            <span class="menu-icon">◷</span> Riwayat
        </a>

        <a href="{{ route('siswa.profil.edit') }}"
           class="menu-item {{ request()->routeIs('siswa.profil.*') ? 'active' : '' }}">
            <span class="menu-icon">♙</span> Profil Saya
        </a>

        <form method="POST" action="{{ route('logout') }}" class="menu-logout">
            @csrf
            <button type="submit"
                    class="menu-item"
                    style="width:100%;border:0;background:transparent;text-align:left;cursor:pointer">
                <span class="menu-icon">↪</span> Keluar
            </button>
        </form>
    </nav>
</aside>