<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('q')) {
            $keyword = $request->q;

            $query->where(function ($q) use ($keyword) {
                $q->where('judul_buku', 'like', "%{$keyword}%")
                    ->orWhere('pengarang', 'like', "%{$keyword}%")
                    ->orWhere('penerbit', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $buku = $query->orderBy('judul_buku')
            ->paginate(12)
            ->withQueryString();

        $kategori = Book::whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('siswa.katalog.index', compact(
            'buku',
            'kategori'
        ));
    }

    public function show(Request $request, Book $book)
    {
        $kuotaMaks = Loan::KUOTA_MAKS;
        $sisaKuota = Loan::sisaKuota($request->user()->id);

        return view('siswa.katalog.detail', compact('book', 'kuotaMaks', 'sisaKuota'));
    }
}