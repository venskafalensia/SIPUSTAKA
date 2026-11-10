<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Pencarian: setiap kata harus ditemukan (urutan bebas, tanda baca diabaikan),
        // jadi "ayat ayat cinta" cocok dengan "Ayat-Ayat Cinta".
        $cari = trim((string) $request->input('search', ''));

        if ($cari !== '') {
            $kataKunci = collect(preg_split('/[\s\-_,.;:()\/]+/u', mb_strtolower($cari), -1, PREG_SPLIT_NO_EMPTY))
                ->unique()
                ->take(8);

            foreach ($kataKunci as $kata) {
                $kata = addcslashes($kata, '%_\\');

                $query->where(function ($q) use ($kata) {
                    $q->where('judul_buku', 'like', "%{$kata}%")
                        ->orWhere('pengarang', 'like', "%{$kata}%")
                        ->orWhere('penerbit', 'like', "%{$kata}%")
                        ->orWhere('isbn', 'like', "%{$kata}%");
                });
            }
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        $books = $query->latest()
            ->orderBy('judul_buku')
            ->paginate(10)
            ->withQueryString();

        $categories = Book::whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        return view('admin.books.create', [
            'kategoris' => $this->daftarKategori(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_buku' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books,isbn',
            'tahun_terbit' => 'required|integer|min:1901|max:' . date('Y'),
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'sampul' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'penerbit.required' => 'Penerbit wajib diisi.',
            'isbn.required' => 'ISBN wajib diisi.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
        ]);

        if ($request->hasFile('sampul')) {
            $validated['sampul'] = $request->file('sampul')
                ->store('sampul', 'public');
        }

        Book::create($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', [
            'book' => $book,
            'kategoris' => $this->daftarKategori($book->kategori),
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'judul_buku' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books,isbn,' . $book->id,
            'tahun_terbit' => 'required|integer|min:1901|max:' . date('Y'),
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'sampul' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'penerbit.required' => 'Penerbit wajib diisi.',
            'isbn.required' => 'ISBN wajib diisi.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
        ]);

        if ($request->hasFile('sampul')) {
            // Hapus sampul lama jika ada
            if ($book->sampul) {
                Storage::disk('public')->delete($book->sampul);
            }

            // Simpan sampul baru
            $validated['sampul'] = $request->file('sampul')
                ->store('sampul', 'public');
        }

        $book->update($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->sampul) {
            Storage::disk('public')->delete($book->sampul);
        }

        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Daftar kategori untuk dropdown form buku: dari tabel kategori, ditambah
     * kategori yang sudah dipakai buku, ditambah kategori buku yang sedang diedit.
     */
    private function daftarKategori(?string $saatIni = null)
    {
        $daftar = Schema::hasTable('kategoris')
            ? DB::table('kategoris')->pluck('nama')
            : collect();

        $daftar = $daftar->merge(
            Book::whereNotNull('kategori')
                ->where('kategori', '!=', '')
                ->distinct()
                ->pluck('kategori')
        );

        if ($saatIni) {
            $daftar->push($saatIni);
        }

        return $daftar->filter()->unique()->sort()->values();
    }
}