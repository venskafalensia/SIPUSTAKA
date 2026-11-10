<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LoanController;

use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\KatalogController as SiswaKatalogController;
use App\Http\Controllers\Siswa\PeminjamanController as SiswaPeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\Siswa\ProfilController as SiswaProfilController;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

    // Tambahkan di bawah route login yang sudah ada
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

/*
|--------------------------------------------------------------------------
| DASHBOARD LAMA
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [
            DashboardController::class,
            'index',
        ])->name('dashboard');

        // Pencarian
        Route::get('/search', [
            DashboardController::class,
            'search',
        ])->name('search');

        // Laporan
        Route::get('/laporan', [
            DashboardController::class,
            'reports',
        ])->name('laporan.index');

        // Buku jatuh tempo
        Route::get('/buku-jatuh-tempo', [
            DashboardController::class,
            'dueDates',
        ])->name('buku.jatuh-tempo');

        // Data Buku
        Route::get('books/export', [\App\Http\Controllers\BookBackupController::class, 'export'])->name('books.export');
Route::post('books/import', [\App\Http\Controllers\BookBackupController::class, 'import'])->name('books.import');
        Route::resource('books', BookController::class);

        // Kategori
        Route::get('/kategori', [
            KategoriController::class,
            'index',
        ])->name('kategori.index');

        Route::post('/kategori', [
            KategoriController::class,
            'store',
        ])->name('kategori.store');

        Route::put('/kategori/{kategori}', [
            KategoriController::class,
            'update',
        ])->name('kategori.update');

        Route::delete('/kategori/{kategori}', [
            KategoriController::class,
            'destroy',
        ])->name('kategori.destroy');

        // Anggota
        Route::get('/anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');
        Route::post('/anggota/import', [AnggotaController::class, 'import'])->name('anggota.import');
        
        Route::get('/anggota', [
            AnggotaController::class,
            'index',
        ])->name('anggota.index');

        Route::post('/anggota', [
            AnggotaController::class,
            'store',
        ])->name('anggota.store');

        Route::put('/anggota/{anggota}', [
            AnggotaController::class,
            'update',
        ])->name('anggota.update');

        Route::delete('/anggota/{anggota}', [
            AnggotaController::class,
            'destroy',
        ])->name('anggota.destroy');

        Route::get('/anggota', [
            AnggotaController::class,
            'index',
        ])->name('anggota.index');

        Route::post('/anggota', [
            AnggotaController::class,
            'store',
        ])->name('anggota.store');

        Route::put('/anggota/{anggota}', [
            AnggotaController::class,
            'update',
        ])->name('anggota.update');

        Route::delete('/anggota/{anggota}', [
            AnggotaController::class,
            'destroy',
        ])->name('anggota.destroy');

        /*
        |--------------------------------------------------------------------------
        | PEMINJAMAN ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get('/peminjaman', [
            LoanController::class,
            'indexPeminjaman',
        ])->name('peminjaman.index');

        Route::post('/peminjaman', [
            LoanController::class,
            'storePeminjaman',
        ])->name('peminjaman.store');

        // Persetujuan pengajuan peminjaman siswa
        Route::patch('/peminjaman/{loan}/setujui', [
            LoanController::class,
            'setujuiPeminjaman',
        ])->name('peminjaman.setujui');

        /*
        |--------------------------------------------------------------------------
        | PENGEMBALIAN ADMIN
        |--------------------------------------------------------------------------
        */
// Halaman pengembalian
                Route::get('/pengembalian', [
            PengembalianController::class,
            'index',
        ])->name('pengembalian.index');

        // Proses pengembalian buku
        Route::patch('/pengembalian/{loan}', [
            PengembalianController::class,
            'process',
        ])->name('pengembalian.proses');
        /*
        |--------------------------------------------------------------------------
        | PROFIL ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get('/profil', [
            ProfilController::class,
            'index',
        ])->name('profil.index');

        Route::put('/profil', [
            ProfilController::class,
            'update',
        ])->name('profil.update');

        Route::put('/profil/password', [
            ProfilController::class,
            'updatePassword',
        ])->name('profil.password');
    });

/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/

Route::prefix('siswa')
    ->name('siswa.')
    ->middleware(['auth', 'role:siswa'])
    ->group(function () {

        // Dashboard Siswa
        Route::get('/dashboard', [
            SiswaDashboardController::class,
            'index',
        ])->name('dashboard');

        // Katalog Buku
        Route::get('/katalog', [
            SiswaKatalogController::class,
            'index',
        ])->name('katalog.index');

        Route::get('/katalog/{book}', [
            SiswaKatalogController::class,
            'show',
        ])->name('katalog.show');

        // Pengajuan dan pemantauan peminjaman siswa
        Route::get('/peminjaman', [
            SiswaPeminjamanController::class,
            'index',
        ])->name('peminjaman.index');

        Route::post('/peminjaman', [
            SiswaPeminjamanController::class,
            'store',
        ])->name('peminjaman.store');

        // Riwayat Peminjaman
        Route::get('/riwayat', [
            SiswaPeminjamanController::class,
            'riwayat',
        ])->name('riwayat');

        // Profil Siswa
        Route::get('/profil', [
            SiswaProfilController::class,
            'edit',
        ])->name('profil.edit');

        Route::put('/profil', [
            SiswaProfilController::class,
            'update',
        ])->name('profil.update');

        Route::put('/profil/password', [
            SiswaProfilController::class,
            'updatePassword',
        ])->name('profil.password');
    });

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
