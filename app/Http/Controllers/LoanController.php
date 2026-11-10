<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    /**
     * HALAMAN ADMIN: DATA PEMINJAMAN
     */
    public function indexPeminjaman(Request $request)
    {
        $q = trim($request->input('q', ''));

        $transaksi = Loan::with(['user', 'book'])
            ->whereNull('tanggal_kembali')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->whereHas('user', function ($userQuery) use ($q) {
                        $userQuery->where('name', 'like', "%{$q}%")
                            ->orWhere('username', 'like', "%{$q}%");
                    })->orWhereHas('book', function ($bookQuery) use ($q) {
                        $bookQuery->where('judul_buku', 'like', "%{$q}%")
                            ->orWhere('pengarang', 'like', "%{$q}%");
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalPeminjaman = Loan::count();

        $totalAktif = Loan::whereNull('tanggal_kembali')
            ->where('status', 'Dipinjam')
            ->count();

        $totalMenungguPersetujuan = Loan::where('status', 'Menunggu')
            ->whereNull('tanggal_kembali')
            ->count();

        $totalSelesai = Loan::whereNotNull('tanggal_kembali')->count();

        $anggota = User::where('role', 'siswa')
            ->orderBy('name')
            ->get();

        $buku = Book::where('stok', '>', 0)
            ->orderBy('judul_buku')
            ->get();

        return view('admin.peminjaman.index', compact(
            'transaksi',
            'totalPeminjaman',
            'totalAktif',
            'totalMenungguPersetujuan',
            'totalSelesai',
            'anggota',
            'buku',
            'q'
        ));
    }

    /**
     * ADMIN: MENYIMPAN TRANSAKSI PEMINJAMAN LANGSUNG
     */
    public function storePeminjaman(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_jatuh_tempo' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
        ]);

        $user = User::findOrFail($validated['user_id']);

        if ($user->role !== 'siswa') {
            throw ValidationException::withMessages([
                'user_id' => 'Peminjaman hanya dapat dicatat untuk anggota siswa.',
            ]);
        }

        DB::transaction(function () use ($validated) {
            $book = Book::whereKey($validated['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($book->stok < $validated['jumlah']) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Stok buku tidak mencukupi.',
                ]);
            }

            Loan::create([
                'user_id' => $validated['user_id'],
                'book_id' => $book->id,
                'tanggal_pinjam' => today()->toDateString(),
                'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
                'tanggal_kembali' => null,
                'jumlah' => $validated['jumlah'],
                'status' => 'Dipinjam',
            ]);

            $book->decrement('stok', $validated['jumlah']);
        });

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Transaksi peminjaman berhasil disimpan.');
    }

    /**
     * ADMIN: MENYETUJUI PENGAJUAN PEMINJAMAN SISWA
     */
    public function setujuiPeminjaman(Loan $loan)
    {
        DB::transaction(function () use ($loan) {
            $transaksi = Loan::whereKey($loan->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($transaksi->status !== 'Menunggu') {
                throw ValidationException::withMessages([
                    'peminjaman' => 'Pengajuan ini sudah diproses atau tidak lagi menunggu persetujuan.',
                ]);
            }

            if ($transaksi->tanggal_kembali !== null) {
                throw ValidationException::withMessages([
                    'peminjaman' => 'Pengajuan ini sudah selesai.',
                ]);
            }

            $book = Book::whereKey($transaksi->book_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($book->stok < $transaksi->jumlah) {
                throw ValidationException::withMessages([
                    'peminjaman' => 'Stok buku tidak mencukupi untuk menyetujui pengajuan ini.',
                ]);
            }

            // Stok baru dikurangi setelah admin menyetujui.
            $book->decrement('stok', $transaksi->jumlah);

            $transaksi->status = 'Dipinjam';
            $transaksi->tanggal_pinjam = today()->toDateString();
            $transaksi->save();
        });

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman siswa berhasil disetujui.');
    }

    /**
     * HALAMAN ADMIN: DATA PENGEMBALIAN
     */
    public function indexPengembalian(Request $request)
    {
        $q = trim($request->input('q', ''));

        $transaksi = Loan::with(['user', 'book'])
            ->whereNull('tanggal_kembali')
            ->whereIn('status', ['Dipinjam', 'Terlambat'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->whereHas('user', function ($userQuery) use ($q) {
                        $userQuery->where('name', 'like', "%{$q}%")
                            ->orWhere('username', 'like', "%{$q}%");
                    })->orWhereHas('book', function ($bookQuery) use ($q) {
                        $bookQuery->where('judul_buku', 'like', "%{$q}%")
                            ->orWhere('pengarang', 'like', "%{$q}%");
                    });
                });
            })
            ->orderBy('tanggal_jatuh_tempo')
            ->paginate(10)
            ->withQueryString();

        $totalMenunggu = Loan::whereNull('tanggal_kembali')
            ->whereIn('status', ['Dipinjam', 'Terlambat'])
            ->count();

        $totalTerlambat = Loan::whereNull('tanggal_kembali')
            ->whereIn('status', ['Dipinjam', 'Terlambat'])
            ->whereDate('tanggal_jatuh_tempo', '<', today())
            ->count();

        $totalDikembalikan = Loan::whereNotNull('tanggal_kembali')->count();

        return view('admin.pengembalian.index', compact(
            'transaksi',
            'totalMenunggu',
            'totalTerlambat',
            'totalDikembalikan',
            'q'
        ));
    }

    /**
     * ADMIN: MEMPROSES PENGEMBALIAN BUKU
     */
    public function prosesPengembalian(Loan $loan)
    {
        DB::transaction(function () use ($loan) {
            $transaksi = Loan::whereKey($loan->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($transaksi->tanggal_kembali !== null) {
                throw ValidationException::withMessages([
                    'pengembalian' => 'Buku ini sudah tercatat dikembalikan.',
                ]);
            }

            if (!in_array($transaksi->status, ['Dipinjam', 'Terlambat'], true)) {
                throw ValidationException::withMessages([
                    'pengembalian' => 'Hanya peminjaman yang sudah disetujui yang dapat dikembalikan.',
                ]);
            }

            $book = Book::whereKey($transaksi->book_id)
                ->lockForUpdate()
                ->firstOrFail();

            $transaksi->tanggal_kembali = today()->toDateString();
            $transaksi->status = 'Dikembalikan';
            $transaksi->save();

            $book->increment('stok', $transaksi->jumlah);
        });

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Buku berhasil dikembalikan dan stok telah diperbarui.');
    }
}
