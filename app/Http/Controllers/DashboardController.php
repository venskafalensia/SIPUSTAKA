<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     */
    public function index()
    {
        // Total stok buku.
        $totalBuku = Book::sum('stok');

        // Total transaksi peminjaman yang masih aktif.
        $transaksiAktif = Loan::where('status', 'Dipinjam')
            ->whereNull('tanggal_kembali')
            ->count();

        // Total transaksi yang terlambat.
        $bukuTerlambat = Loan::whereNull('tanggal_kembali')
            ->whereDate('tanggal_jatuh_tempo', '<', now()->toDateString())
            ->count();

        // Total anggota siswa.
        $totalAnggota = User::where('role', 'siswa')->count();

        // Lima aktivitas peminjaman terbaru.
        $aktivitasTerbaru = Loan::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        // Lima transaksi yang jatuh tempo dalam tujuh hari ke depan
        // atau sudah terlambat.
        $bukuJatuhTempo = Loan::with(['user', 'book'])
            ->whereNull('tanggal_kembali')
            ->whereDate(
                'tanggal_jatuh_tempo',
                '<=',
                now()->addDays(7)->toDateString()
            )
            ->orderBy('tanggal_jatuh_tempo')
            ->take(5)
            ->get();

        // Data peminjaman bulanan untuk grafik dashboard.
        $peminjamanBulanan = Loan::selectRaw(
            'MONTH(tanggal_pinjam) as bulan, COUNT(*) as total'
        )
            ->whereYear('tanggal_pinjam', now()->year)
            ->groupByRaw('MONTH(tanggal_pinjam)')
            ->orderByRaw('MONTH(tanggal_pinjam)')
            ->pluck('total', 'bulan')
            ->toArray();
                
        return view('admin.dashboard', compact(
            'totalBuku',
            'transaksiAktif',
            'bukuTerlambat',
            'totalAnggota',
            'aktivitasTerbaru',
            'bukuJatuhTempo',
            'peminjamanBulanan'
        ));
    }

    /**
     * Mencari buku dan anggota.
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $q = trim($request->input('q', ''));

        // Pencarian buku.
        $books = Book::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('judul_buku', 'like', "%{$q}%")
                        ->orWhere('pengarang', 'like', "%{$q}%")
                        ->orWhere('penerbit', 'like', "%{$q}%")
                        ->orWhere('isbn', 'like', "%{$q}%")
                        ->orWhere('kategori', 'like', "%{$q}%");
                });
            })
            ->orderBy('judul_buku')
            ->paginate(10)
            ->withQueryString();

        // Pencarian anggota.
        $users = User::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('name', 'like', "%{$q}%")
                        ->orWhere('username', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(10, ['*'], 'anggota_page')
            ->withQueryString();

        return view('admin.search', compact(
            'q',
            'books',
            'users'
        ));
    }

    /**
     * Menampilkan laporan transaksi peminjaman.
     */
    public function reports(Request $request)
    {
        $totalPeminjaman = Loan::count();

        $totalPengembalian = Loan::where(
            'status',
            'Dikembalikan'
        )->count();

        $totalTerlambat = Loan::whereNull('tanggal_kembali')
            ->whereDate(
                'tanggal_jatuh_tempo',
                '<',
                now()->toDateString()
            )
            ->count();

        $peminjamanAktif = Loan::where('status', 'Dipinjam')
            ->whereNull('tanggal_kembali')
            ->count();

        $peminjamanSelesai = Loan::where(
            'status',
            'Dikembalikan'
        )->count();

        // Variabel $peminjamans disiapkan untuk tabel laporan & perhitungan denda
        $peminjamans = Loan::with(['user', 'book'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.laporan.index', compact(
            'totalPeminjaman',
            'totalPengembalian',
            'totalTerlambat',
            'peminjamanAktif',
            'peminjamanSelesai',
            'peminjamans'
        ));
    }

    /**
     * Menampilkan transaksi yang mendekati jatuh tempo
     * atau sudah terlambat.
     */
    public function dueDates()
    {
        $bukuJatuhTempo = Loan::with(['user', 'book'])
            ->whereNull('tanggal_kembali')
            ->whereDate(
                'tanggal_jatuh_tempo',
                '<=',
                now()->addDays(7)->toDateString()
            )
            ->orderBy('tanggal_jatuh_tempo')
            ->paginate(15);

        return view(
            'admin.laporan.jatuh-tempo',
            compact('bukuJatuhTempo')
        );
    }
}