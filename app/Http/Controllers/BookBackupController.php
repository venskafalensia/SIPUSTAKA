<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class BookBackupController extends Controller
{
    /** Urutan kolom pada file CSV. */
    private const KOLOM = [
        'judul_buku', 'pengarang', 'penerbit', 'isbn',
        'kategori', 'tahun_terbit', 'stok', 'deskripsi', 'sampul',
    ];

    /** Nama kolom lain yang tetap dikenali saat impor. */
    private const ALIAS = [
        'judul' => 'judul_buku',
        'title' => 'judul_buku',
        'nama_buku' => 'judul_buku',
        'penulis' => 'pengarang',
        'author' => 'pengarang',
        'tahun' => 'tahun_terbit',
        'jumlah' => 'stok',
        'eksemplar' => 'stok',
    ];

    /*
    |--------------------------------------------------------------------------
    | EKSPOR: unduh semua buku sebagai CSV
    |--------------------------------------------------------------------------
    */

    public function export(): StreamedResponse
    {
        $nama = 'backup-buku-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');

            fwrite($out, "\xEF\xBB\xBF"); // BOM supaya Excel membaca huruf UTF-8 dengan benar
            fputcsv($out, self::KOLOM, ';', '"', '');

            Book::orderBy('id')->chunk(200, function ($books) use ($out) {
                foreach ($books as $b) {
                    fputcsv($out, [
                        $this->amanExcel($b->judul_buku),
                        $this->amanExcel($b->pengarang),
                        $this->amanExcel($b->penerbit),
                        // ="..." menjaga ISBN tetap berupa teks di Excel (tidak jadi 9,79E+12)
                        '="' . $b->isbn . '"',
                        $this->amanExcel($b->kategori),
                        $b->tahun_terbit,
                        $b->stok,
                        $this->amanExcel($b->deskripsi),
                        $b->sampul,
                    ], ';', '"', '');
                }
            });

            fclose($out);
        }, $nama, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /*
    |--------------------------------------------------------------------------
    | IMPOR: baca CSV lalu tambah / perbarui buku
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {
        // Validasi dasar saja. Jenis file dicek lewat ekstensi (di bawah),
        // karena aturan "mimes" sering menolak CSV buatan Excel.
        $request->validate([
            'file' => 'required|file|max:5120',
        ], [
            'file.required' => 'Pilih file CSV terlebih dahulu.',
            'file.file' => 'File gagal diunggah. Coba pilih ulang file CSV-nya.',
            'file.uploaded' => 'File gagal diunggah. Ukuran file mungkin melebihi batas server (upload_max_filesize).',
            'file.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        $file = $request->file('file');
        $ekstensi = strtolower($file->getClientOriginalExtension());

        if (! in_array($ekstensi, ['csv', 'txt'], true)) {
            return back()->with('error', 'File harus berformat CSV (.csv). File yang dipilih: .' . $ekstensi);
        }

        $perbarui = $request->boolean('perbarui');

        $isi = file_get_contents($file->getRealPath());
        $isi = $this->keUtf8((string) $isi);

        if (trim($isi) === '') {
            return back()->with('error', 'File CSV kosong.');
        }

        // Pemisah kolom: titik koma (Excel Indonesia), koma, atau tab
        $pemisah = $this->tebakPemisah($isi);

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $isi);
        rewind($stream);

        // Cari baris judul kolom (baris pertama yang tidak kosong)
        $header = null;
        $baris = 0;

        while (($r = fgetcsv($stream, 0, $pemisah, '"', '')) !== false) {
            $baris++;

            if (count(array_filter($r, fn ($v) => trim((string) $v) !== '')) > 0) {
                $header = $r;
                break;
            }
        }

        $header = array_map(function ($h) {
            $h = strtolower(trim((string) $h));
            $h = str_replace([' ', '-', '.'], '_', $h);

            return self::ALIAS[$h] ?? $h;
        }, $header ?: []);

        if (! in_array('judul_buku', $header, true) || ! in_array('isbn', $header, true)) {
            fclose($stream);

            $ditemukan = implode(', ', array_filter($header)) ?: '(tidak ada)';

            return back()->with('error',
                'Kolom judul_buku dan isbn tidak ditemukan. Kolom yang terbaca: ' . $ditemukan .
                '. Gunakan file hasil Ekspor sebagai contoh format.'
            );
        }

        $ditambah = 0;
        $diperbarui = 0;
        $dilewati = 0;
        $gagal = 0;
        $pesan = [];
        $tahunSekarang = (int) date('Y');

        while (($row = fgetcsv($stream, 0, $pemisah, '"', '')) !== false) {
            $baris++;

            if (count(array_filter($row, fn ($v) => trim((string) $v) !== '')) === 0) {
                continue; // baris kosong
            }

            $row = array_pad($row, count($header), '');
            $d = array_combine($header, array_slice($row, 0, count($header)));

            $judul = $this->bersih($d['judul_buku'] ?? '');
            $pengarang = $this->bersih($d['pengarang'] ?? '') ?: '-';
            $isbn = strtoupper(preg_replace('/[^0-9Xx]/', '', (string) ($d['isbn'] ?? '')));
            $tahunMentah = preg_replace('/\D/', '', (string) ($d['tahun_terbit'] ?? ''));
            $tahun = $tahunMentah === '' ? $tahunSekarang : (int) $tahunMentah;
            $stokMentah = trim((string) ($d['stok'] ?? ''));

            $err = null;

            if ($judul === '') {
                $err = 'judul_buku kosong';
            } elseif (! in_array(strlen($isbn), [10, 13], true)) {
                $err = 'ISBN harus 10 atau 13 angka (jangan simpan ulang CSV lewat Excel, ISBN bisa rusak)';
            } elseif ($tahun < 1901 || $tahun > $tahunSekarang) {
                $err = "tahun_terbit tidak valid (1901 sampai {$tahunSekarang})";
            } elseif ($stokMentah !== '' && ! ctype_digit($stokMentah)) {
                $err = 'stok harus berupa angka bulat';
            }

            if ($err) {
                $gagal++;
                $pesan[] = "Baris {$baris}: {$err}.";

                continue;
            }

            $data = [
                'judul_buku' => $judul,
                'pengarang' => $pengarang,
                'penerbit' => $this->bersih($d['penerbit'] ?? '') ?: '-',
                'isbn' => $isbn,
                'kategori' => $this->bersih($d['kategori'] ?? '') ?: 'Umum',
                'tahun_terbit' => $tahun,
                'stok' => $stokMentah === '' ? 0 : (int) $stokMentah,
                'deskripsi' => $this->bersih($d['deskripsi'] ?? '') ?: null,
            ];

            $sampul = trim((string) ($d['sampul'] ?? ''));
            if ($sampul !== '' && ! str_contains($sampul, '..') && preg_match('#^[\w\-./ ]+$#', $sampul)) {
                $data['sampul'] = $sampul;
            }

            try {
                $book = Book::where('isbn', $isbn)->first();

                if ($book) {
                    if ($perbarui) {
                        $book->update($data);
                        $diperbarui++;
                    } else {
                        $dilewati++;
                    }
                } else {
                    Book::create($data);
                    $ditambah++;
                }
            } catch (Throwable $e) {
                $gagal++;
                $pesan[] = "Baris {$baris}: gagal disimpan (" . mb_substr($e->getMessage(), 0, 120) . ').';
            }
        }

        fclose($stream);

        $ringkas = "Impor selesai: {$ditambah} buku ditambahkan";
        if ($perbarui) {
            $ringkas .= ", {$diperbarui} diperbarui";
        }
        $ringkas .= ", {$dilewati} dilewati (ISBN sudah ada)";
        if ($gagal) {
            $ringkas .= ", {$gagal} baris bermasalah";
        }
        $ringkas .= '.';

        // Jika tidak ada satu pun yang masuk dan ada baris bermasalah, tampilkan sebagai kesalahan
        $berhasil = $ditambah + $diperbarui;
        $jenis = ($berhasil === 0 && $gagal > 0) ? 'error' : 'success';

        return redirect()
            ->route('admin.books.index')
            ->with($jenis, $ringkas)
            ->with('import_errors', array_slice($pesan, 0, 20));
    }

    /*
    |--------------------------------------------------------------------------
    | PEMBANTU
    |--------------------------------------------------------------------------
    */

    /** Tebak pemisah kolom dari baris pertama yang tidak kosong. */
    private function tebakPemisah(string $isi): string
    {
        $pertama = '';

        foreach (preg_split('/\R/', $isi) as $baris) {
            if (trim($baris) !== '') {
                $pertama = $baris;
                break;
            }
        }

        $hitung = [
            ';' => substr_count($pertama, ';'),
            ',' => substr_count($pertama, ','),
            "\t" => substr_count($pertama, "\t"),
        ];

        arsort($hitung);

        return array_key_first($hitung);
    }

    /** Ubah ke UTF-8 dan buang BOM; file dari Excel lama biasanya Windows-1252. */
    private function keUtf8(string $isi): string
    {
        $isi = preg_replace('/^\xEF\xBB\xBF/', '', $isi);

        if (! mb_check_encoding($isi, 'UTF-8')) {
            $isi = mb_convert_encoding($isi, 'UTF-8', 'Windows-1252');
        }

        return $isi;
    }

    /** Rapikan spasi dan buang tanda ' pelindung rumus dari ekspor. */
    private function bersih(?string $nilai): string
    {
        $nilai = trim(preg_replace('/\s+/', ' ', (string) $nilai));

        return preg_replace("/^'(?=[=+\-@])/", '', $nilai);
    }

    /** Cegah teks diawali = + - @ dibaca Excel sebagai rumus. */
    private function amanExcel(?string $nilai): ?string
    {
        if ($nilai !== null && preg_match('/^[=+\-@]/', $nilai)) {
            return "'" . $nilai;
        }

        return $nilai;
    }
}