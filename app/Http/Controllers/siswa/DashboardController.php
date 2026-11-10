<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // <-- Mengambil data user yang sedang login
        $userId = auth()->id();

        $totalMenunggu = Loan::where('user_id', $userId)
            ->where('status', 'Menunggu')
            ->count();

        $totalDipinjam = Loan::where('user_id', $userId)
            ->whereIn('status', ['Dipinjam', 'Terlambat'])
            ->whereNull('tanggal_kembali')
            ->count();

        $totalTerlambat = Loan::where('user_id', $userId)
            ->whereNull('tanggal_kembali')
            ->whereDate('tanggal_jatuh_tempo', '<', today())
            ->whereIn('status', ['Dipinjam', 'Terlambat'])
            ->count();

        $peminjamanTerbaru = Loan::with('book')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $bukuPilihan = Book::where('stok', '>', 0)
            ->orderBy('judul_buku')
            ->take(4)
            ->get();

        // Jumlah koleksi dan ringkasan
        $totalBuku = Book::count();
        $totalJudul = $totalBuku;
        $totalEksemplar = (int) Book::sum('stok');
        $totalAnggota = User::count();
        $peminjamanAktif = $totalDipinjam;

        // 3 buku terbaru yang stoknya masih ada
        $bukuBaru = Book::where('stok', '>', 0)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->take(3)
            ->get();

        // 3 buku yang paling sering dipinjam
        $bukuTerlaris = Loan::query()
            ->whereIn('status', ['Dipinjam', 'Terlambat', 'Dikembalikan'])
            ->selectRaw('book_id, COUNT(*) as total_pinjam')
            ->groupBy('book_id')
            ->orderByDesc('total_pinjam')
            ->orderBy('book_id')
            ->take(3)
            ->with('book')
            ->get()
            ->filter(fn ($row) => $row->book);

        return view('siswa.dashboard', compact(
            'user',
            'totalBuku',
            'totalAnggota',
            'peminjamanAktif',
            'totalMenunggu',
            'totalDipinjam',
            'totalTerlambat',
            'peminjamanTerbaru',
            'bukuPilihan',
            'totalJudul',
            'totalEksemplar',
            'bukuBaru',
            'bukuTerlaris'
        ));
    }
}