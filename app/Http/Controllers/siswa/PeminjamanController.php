<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Loan::with('book')
            ->where('user_id', auth()->id())
            ->whereIn('status', [
                'Menunggu',
                'Dipinjam',
                'Terlambat',
            ])
            ->whereNull('tanggal_kembali')
            ->latest()
            ->paginate(10);

        return view('siswa.peminjaman.index', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:5'],
            'tanggal_jatuh_tempo' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
        ]);

        DB::transaction(function () use ($data) {
            $book = Book::whereKey($data['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($book->stok < 1) {
                throw ValidationException::withMessages([
                    'book_id' => 'Maaf, stok buku sedang habis.',
                ]);
            }

            if ($data['jumlah'] > $book->stok) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Jumlah melebihi stok buku yang tersedia.',
                ]);
            }

            $sudahAda = Loan::where('user_id', auth()->id())
                ->where('book_id', $book->id)
                ->whereIn('status', [
                    'Menunggu',
                    'Dipinjam',
                    'Terlambat',
                ])
                ->whereNull('tanggal_kembali')
                ->exists();

            if ($sudahAda) {
                throw ValidationException::withMessages([
                    'book_id' => 'Kamu masih memiliki pengajuan atau pinjaman aktif untuk buku ini.',
                ]);
            }

            Loan::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'tanggal_pinjam' => today(),
                'tanggal_jatuh_tempo' => $data['tanggal_jatuh_tempo'],
                'tanggal_kembali' => null,
                'jumlah' => $data['jumlah'],
                'status' => 'Menunggu',
            ]);
        });

        return redirect()
            ->route('siswa.peminjaman.index')
            ->with('success', 'Pengajuan berhasil dikirim. Tunggu persetujuan admin.');
    }

    public function riwayat()
    {
        $riwayat = Loan::with('book')
            ->where('user_id', auth()->id())
            ->whereNotNull('tanggal_kembali')
            ->latest('tanggal_kembali')
            ->paginate(10);

        return view('siswa.peminjaman.riwayat', compact('riwayat'));
    }
}