<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    // Denda keterlambatan per hari.
    public const DENDA_PER_HARI = 1000;

    /**
     * Halaman pengembalian buku.
     */
    public function index(Request $request)
    {
        $hariIni = Carbon::today()->toDateString();

        // Kata kunci pencarian.
        $q = trim($request->input('q', ''));

        // Filter pencarian anggota dan buku.
        $cari = function ($query) use ($q) {
            $query->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->whereHas('user', function ($u) use ($q) {
                        $u->where('name', 'like', "%{$q}%")
                          ->orWhere('username', 'like', "%{$q}%");
                    })
                    ->orWhereHas('book', function ($b) use ($q) {
                        $b->where('judul_buku', 'like', "%{$q}%");
                    });
                });
            });
        };

        // Peminjaman yang belum dikembalikan.
        $aktif = Loan::with(['user', 'book'])
            ->whereNull('tanggal_kembali')
            ->tap($cari)
            ->orderBy('tanggal_jatuh_tempo')
            ->paginate(10, ['*'], 'aktif')
            ->withQueryString();

        // Riwayat peminjaman yang sudah dikembalikan.
        $riwayat = Loan::with(['user', 'book'])
            ->whereNotNull('tanggal_kembali')
            ->tap($cari)
            ->orderByDesc('tanggal_kembali')
            ->paginate(10, ['*'], 'riwayat')
            ->withQueryString();

        // Statistik pengembalian.
        $totalAktif = Loan::whereNull('tanggal_kembali')->count();

        // Alias untuk Blade.
        $totalMenunggu = $totalAktif;

        $totalTerlambat = Loan::whereNull('tanggal_kembali')
            ->whereDate('tanggal_jatuh_tempo', '<', $hariIni)
            ->count();

        $totalDikembalikan = Loan::whereNotNull('tanggal_kembali')
            ->count();

        $kembaliHariIni = Loan::whereDate(
            'tanggal_kembali',
            $hariIni
        )->count();

        $dendaPerHari = self::DENDA_PER_HARI;

        // Kirim semua variabel ke Blade.
        return view('admin.pengembalian.index', compact(
            'aktif',
            'riwayat',
            'q',
            'totalAktif',
            'totalMenunggu',
            'totalTerlambat',
            'totalDikembalikan',
            'kembaliHariIni',
            'dendaPerHari'
        ));
    }

    /**
     * Memproses pengembalian buku.
     */
    public function process(Loan $loan)
    {
        $hasil = DB::transaction(function () use ($loan) {

            $peminjaman = Loan::whereKey($loan->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Cegah pengembalian ganda.
            if ($peminjaman->tanggal_kembali !== null) {
                return [
                    'sudah_kembali' => true,
                    'telat' => 0,
                    'denda' => 0,
                ];
            }

            $hariIni = Carbon::today();

            $tempo = Carbon::parse(
                $peminjaman->tanggal_jatuh_tempo
            )->startOfDay();

            // Hitung keterlambatan.
            $telat = $hariIni->gt($tempo)
                ? (int) $tempo->diffInDays($hariIni)
                : 0;

            $denda = $telat * self::DENDA_PER_HARI;

            // Catat pengembalian.
            $peminjaman->forceFill([
                'tanggal_kembali' => $hariIni->toDateString(),
                'status' => 'Dikembalikan',
            ])->save();

            // Tambahkan stok buku.
            Book::whereKey($peminjaman->book_id)
                ->increment(
                    'stok',
                    max(1, (int) $peminjaman->jumlah)
                );

            return [
                'sudah_kembali' => false,
                'telat' => $telat,
                'denda' => $denda,
            ];
        });

        if ($hasil['sudah_kembali']) {
            return back()->with(
                'error',
                'Buku ini sudah dikembalikan sebelumnya.'
            );
        }

        $pesan = 'Pengembalian berhasil dicatat.';

        if ($hasil['denda'] > 0) {
            $pesan .= ' Terlambat '
                . $hasil['telat']
                . ' hari, denda Rp '
                . number_format($hasil['denda'], 0, ',', '.')
                . '.';
        }

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', $pesan);
    }
}
