<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $hariIni = Carbon::today()->toDateString();

        $loans = Loan::with(['user', 'book'])
            ->when($request->search, function ($q, $s) {
                $q->where(function ($w) use ($s) {
                    $w->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$s}%")->orWhere('username', 'like', "%{$s}%"))
                      ->orWhereHas('book', fn ($b) => $b->where('judul_buku', 'like', "%{$s}%"));
                });
            })
            ->when($request->status === 'dipinjam', fn ($q) => $q->whereNull('tanggal_kembali')->whereDate('tanggal_jatuh_tempo', '>=', $hariIni))
            ->when($request->status === 'terlambat', fn ($q) => $q->whereNull('tanggal_kembali')->whereDate('tanggal_jatuh_tempo', '<', $hariIni))
            ->when($request->status === 'dikembalikan', fn ($q) => $q->whereNotNull('tanggal_kembali'))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $totalAktif = Loan::whereNull('tanggal_kembali')->count();
        $totalTerlambat = Loan::whereNull('tanggal_kembali')->whereDate('tanggal_jatuh_tempo', '<', $hariIni)->count();
        $totalTransaksi = Loan::count();

        $anggotas = User::where('role', '!=', 'admin')->orderBy('name')->get(['id', 'name', 'username']);
        $books = Book::where('stok', '>', 0)->orderBy('judul_buku')->get(['id', 'judul_buku', 'stok']);

        return view('admin.peminjaman.index', compact(
            'loans', 'totalAktif', 'totalTerlambat', 'totalTransaksi', 'anggotas', 'books'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'lama_pinjam' => 'required|integer|min:1|max:30',
        ]);

        $tanggalPinjam = Carbon::parse($data['tanggal_pinjam']);
        $jatuhTempo = $tanggalPinjam->copy()->addDays((int) $data['lama_pinjam']);

        $error = null;

        DB::transaction(function () use ($data, $tanggalPinjam, $jatuhTempo, &$error) {
            $book = Book::lockForUpdate()->find($data['book_id']);

            if ($book->stok < 1) {
                $error = 'Stok buku habis, peminjaman tidak bisa dicatat.';
                return;
            }

            $sudahPinjam = Loan::where('user_id', $data['user_id'])
                ->where('book_id', $data['book_id'])
                ->whereNull('tanggal_kembali')
                ->exists();

            if ($sudahPinjam) {
                $error = 'Anggota ini masih meminjam buku yang sama dan belum mengembalikannya.';
                return;
            }

            Loan::forceCreate([
                'user_id' => $data['user_id'],
                'book_id' => $data['book_id'],
                'tanggal_pinjam' => $tanggalPinjam->toDateString(),
                'tanggal_jatuh_tempo' => $jatuhTempo->toDateString(),
                'jumlah' => 1,
                'status' => 'Dipinjam',
            ]);

            $book->decrement('stok');
        });

        if ($error) {
            return back()->withInput()->with('error', $error);
        }

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }
}