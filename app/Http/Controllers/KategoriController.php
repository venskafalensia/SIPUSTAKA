<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::withCount('books')
            ->when($request->search, fn ($q, $s) => $q->where('nama', 'like', "%{$s}%"))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        $totalKategori = Kategori::count();
        $totalBuku = Book::count();

        return view('admin.kategori.index', compact('kategoris', 'totalKategori', 'totalBuku'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100|unique:kategoris,nama',
            'deskripsi' => 'nullable|string|max:255',
        ]);
        Kategori::create($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100|unique:kategoris,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($kategori, $data) {
            $lama = $kategori->nama;
            $kategori->update($data);
            // ikut ubah nama kategori di buku-buku yang memakainya
            if ($lama !== $data['nama']) {
                Book::where('kategori', $lama)->update(['kategori' => $data['nama']]);
            }
        });

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->books()->exists()) {
            return back()->with('error', 'Kategori masih dipakai oleh buku, tidak bisa dihapus.');
        }
        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}