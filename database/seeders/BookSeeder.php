<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * 50 buku dari Buku Induk Perpustakaan SMK N 5 Surakarta.
 *
 * FOTO SAMPUL
 * -----------
 * Taruh foto di:  storage/app/public/sampul/
 * Nama file    :  <ISBN>.jpg   (contoh: 9786238829651.jpg)
 * Format       :  jpg, jpeg, png, atau webp
 *
 * Setelah foto ditaruh, jalankan lagi:
 *     php artisan db:seed --class=BookSeeder
 * Seeder ini aman dijalankan berulang kali: buku yang sudah ada tidak
 * dobel dan stoknya tidak diubah, hanya kolom sampul yang diperbarui.
 */
class BookSeeder extends Seeder
{
    /** Ekstensi foto yang dikenali, berurutan. */
    private const EKSTENSI = ['jpg', 'jpeg', 'png', 'webp'];

    public function run(): void
    {
        $disk = Storage::disk('public');
        $disk->makeDirectory('sampul'); // folder foto dibuat otomatis

        $ditambah = 0;
        $dapatSampul = 0;
        $tanpaSampul = [];

        foreach ($this->daftarBuku() as $data) {
            $book = Book::firstOrNew(['isbn' => $data['isbn']]);

            // data buku hanya diisi saat buku baru, supaya stok yang sudah
            // berubah karena peminjaman tidak ikut tertimpa
            if (! $book->exists) {
                $book->fill($data);
                $ditambah++;
            }

            $sampul = $this->cariSampul($data['isbn']);

            if ($sampul) {
                $book->sampul = $sampul;
                $dapatSampul++;
            } else {
                $tanpaSampul[] = $data['isbn'] . '  ' . $data['judul_buku'];
            }

            $book->save();
        }

        $this->sinkronKategori();

        $this->command->info("Buku baru ditambahkan : {$ditambah}");
        $this->command->info("Buku dengan sampul    : {$dapatSampul}");
        $this->command->info('Buku tanpa sampul     : ' . count($tanpaSampul));

        if ($tanpaSampul) {
            $this->command->line('Belum ada foto untuk (nama file = ISBN):');
            foreach ($tanpaSampul as $baris) {
                $this->command->line('  ' . $baris);
            }
        }
    }

    /** Cari foto <isbn>.jpg/.png/... di storage/app/public/sampul. */
    private function cariSampul(string $isbn): ?string
    {
        foreach (self::EKSTENSI as $ext) {
            $path = "sampul/{$isbn}.{$ext}";

            if (Storage::disk('public')->exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /** Pastikan kategori juga muncul di halaman Kategori admin. */
    private function sinkronKategori(): void
    {
        if (! Schema::hasTable('kategoris') || ! Schema::hasColumn('kategoris', 'nama')) {
            return;
        }

        $nama = collect($this->daftarBuku())->pluck('kategori')->unique();

        foreach ($nama as $n) {
            if (DB::table('kategoris')->where('nama', $n)->exists()) {
                continue;
            }

            $data = ['nama' => $n];

            if (Schema::hasColumn('kategoris', 'created_at')) {
                $data['created_at'] = now();
            }
            if (Schema::hasColumn('kategoris', 'updated_at')) {
                $data['updated_at'] = now();
            }

            DB::table('kategoris')->insert($data);
        }
    }

    /** @return array<int, array<string, mixed>> */
    private function daftarBuku(): array
    {
        return [
            [
                'judul_buku'   => 'Ayahku (Bukan) Pembohong',
                'pengarang'    => 'Tere Liye',
                'penerbit'     => 'Sabak Grip',
                'isbn'         => '9786238829651',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Ayat-Ayat Cinta',
                'pengarang'    => 'Habibur Rahman',
                'penerbit'     => 'Republika',
                'isbn'         => '9793604026',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2004,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Bawalah Mayatku Pada Kekasihku',
                'pengarang'    => 'Martana Rusti',
                'penerbit'     => 'DivaPress',
                'isbn'         => '9786020822648',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2022,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Bedebah Di Ujung Tanduk',
                'pengarang'    => 'Tere Liye',
                'penerbit'     => 'Sabak Grip',
                'isbn'         => '9786239726218',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Berjuta Rasanya',
                'pengarang'    => 'Tere Liye',
                'penerbit'     => 'Sabak Grip',
                'isbn'         => '9786239554538',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Bidadri Bermata Bening',
                'pengarang'    => 'Habibur Rahman',
                'penerbit'     => 'Republika',
                'isbn'         => '9786023918379',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2017,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Bumi Cinta',
                'pengarang'    => 'Habiburrahman',
                'penerbit'     => 'Republika',
                'isbn'         => '9786025734687',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2022,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Dilarang Bercanda dengan Kenangan',
                'pengarang'    => 'Akmal N',
                'penerbit'     => 'Republika',
                'isbn'         => '9786025734458',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2018,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Drama Mangir',
                'pengarang'    => 'Pramoedya Ananta',
                'penerbit'     => 'Kompas Gramedia',
                'isbn'         => '9786022916512',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2020,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Harga Sebuah Percaya',
                'pengarang'    => 'Tere Liye',
                'penerbit'     => 'Sabak Grip',
                'isbn'         => '9786239607456',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Jo & Kas',
                'pengarang'    => 'Asma Nadia',
                'penerbit'     => 'Republika',
                'isbn'         => '9786232790858',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2020,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Kachu & Moli',
                'pengarang'    => 'Roy Adimulyo',
                'penerbit'     => 'Kompas Gramedia',
                'isbn'         => '9786026208804',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Kau, Aku, & Sepucuk Angpau Merah',
                'pengarang'    => 'Tere Liye',
                'penerbit'     => 'Sabak Grip',
                'isbn'         => '9786238829668',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Kita, Kata, & Cinta',
                'pengarang'    => 'Khrisna Pabichara',
                'penerbit'     => 'Diva Press',
                'isbn'         => '9786023916948',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2019,
                'stok'         => 1,
            ],
            [
                'judul_buku'   => 'Klara The Sun',
                'pengarang'    => 'Kazuro I',
                'penerbit'     => 'Kompas Gramedia',
                'isbn'         => '9786231341099',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Kun Fayakun',
                'pengarang'    => 'Andi Bombang',
                'penerbit'     => 'Diva Press',
                'isbn'         => '9786023917112',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2019,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Mati Bahagia',
                'pengarang'    => 'Albert Camus',
                'penerbit'     => 'Diva Press',
                'isbn'         => '9786023916979',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2019,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Merindu Baginda Nabi',
                'pengarang'    => 'Habiburrahman',
                'penerbit'     => 'Republika',
                'isbn'         => '9786025734199',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Negeri Di Ujung Tanduk',
                'pengarang'    => 'Tere Liye',
                'penerbit'     => 'Sabak Grip',
                'isbn'         => '9786238829637',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Perjalanan Ke Timur',
                'pengarang'    => 'Herman H',
                'penerbit'     => 'Basa Basi',
                'isbn'         => '9786233052702',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2022,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Pria Tak Tampak',
                'pengarang'    => 'H.G Well',
                'penerbit'     => 'Basa Basi',
                'isbn'         => '9786233052559',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2021,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Rembulan Tenggelam di Wajahmu',
                'pengarang'    => 'Tere Liye',
                'penerbit'     => 'Sabak Grip',
                'isbn'         => '9786239607449',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Rumah Tanpa Jendela',
                'pengarang'    => 'Nadia Asmara',
                'penerbit'     => 'Republika',
                'isbn'         => '9786020822853',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2022,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Sayap-Sayap Patah',
                'pengarang'    => 'Khalil Gibran',
                'penerbit'     => 'Diva Press',
                'isbn'         => '9786232937123',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2022,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Seberapa Candu Cinta Itu?',
                'pengarang'    => 'Eko Triono',
                'penerbit'     => 'Basa Basi',
                'isbn'         => '9786237290520',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2019,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Seopotong Hati Yang Baru',
                'pengarang'    => 'Tere Liye',
                'penerbit'     => 'Sabak Grip',
                'isbn'         => '9786239554545',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Serdadu Dari Neraka',
                'pengarang'    => 'Arafat Nur',
                'penerbit'     => 'Diva Press',
                'isbn'         => '9786023918157',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2019,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Teruslah Bodoh Jangan Pintar',
                'pengarang'    => 'Tere Liye',
                'penerbit'     => 'Sabak Grip',
                'isbn'         => '9786238882205',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Titip Rindu Ke Tanah Suci',
                'pengarang'    => 'Aguk Irawan',
                'penerbit'     => 'Republika',
                'isbn'         => '9786020822877',
                'kategori'     => 'Novel',
                'tahun_terbit' => 2017,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Tokyo Revengers 17',
                'pengarang'    => 'Ken Wakui',
                'penerbit'     => 'ElexMedia',
                'isbn'         => '9786230069567',
                'kategori'     => 'Komik',
                'tahun_terbit' => 2020,
                'stok'         => 1,
            ],
            [
                'judul_buku'   => 'Tokyo Revengers 20',
                'pengarang'    => 'Ken Wakui',
                'penerbit'     => 'ElexMedia',
                'isbn'         => '9786230059575',
                'kategori'     => 'Komik',
                'tahun_terbit' => 2020,
                'stok'         => 1,
            ],
            [
                'judul_buku'   => 'Wind Breaker 11',
                'pengarang'    => 'Satoruni',
                'penerbit'     => 'Gramedia',
                'isbn'         => '9786347128485',
                'kategori'     => 'Komik',
                'tahun_terbit' => 2025,
                'stok'         => 1,
            ],
            [
                'judul_buku'   => 'Wind Breaker 12',
                'pengarang'    => 'Satoruni',
                'penerbit'     => 'Gramedia',
                'isbn'         => '9786347128478',
                'kategori'     => 'Komik',
                'tahun_terbit' => 2025,
                'stok'         => 1,
            ],
            [
                'judul_buku'   => 'Hal-Hal Yang Harus Dilakukan Sebelum Umur 20 Tahun',
                'pengarang'    => 'Heru S',
                'penerbit'     => 'Kaktus',
                'isbn'         => '9786020795058',
                'kategori'     => 'Pengembangan Diri',
                'tahun_terbit' => 2019,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Mencari Kedamaian Jiwa',
                'pengarang'    => 'Carl G',
                'penerbit'     => 'IRCiSoD',
                'isbn'         => '9786235348056',
                'kategori'     => 'Pengembangan Diri',
                'tahun_terbit' => 2022,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Nasehat-Nasehat Hidup Orang Jawa',
                'pengarang'    => 'Imam Budi S',
                'penerbit'     => 'Noktah',
                'isbn'         => '9786236175231',
                'kategori'     => 'Pengembangan Diri',
                'tahun_terbit' => 2021,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Seni Berbahagia',
                'pengarang'    => 'Epicurus',
                'penerbit'     => 'BasaBasi',
                'isbn'         => '9786237290452',
                'kategori'     => 'Pengembangan Diri',
                'tahun_terbit' => 2019,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Seni Mendengarkan',
                'pengarang'    => 'Erick F',
                'penerbit'     => 'IRCiSoD',
                'isbn'         => '9786236166581',
                'kategori'     => 'Pengembangan Diri',
                'tahun_terbit' => 2021,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Seni Sederhana Menaklukan Negative Vibes',
                'pengarang'    => 'Coky Aditya',
                'penerbit'     => 'Noktah',
                'isbn'         => '9786236175385',
                'kategori'     => 'Pengembangan Diri',
                'tahun_terbit' => 2022,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Stop Bullying',
                'pengarang'    => 'Icampus Indonesia',
                'penerbit'     => 'Andi Offset',
                'isbn'         => '9786237851745',
                'kategori'     => 'Pengembangan Diri',
                'tahun_terbit' => 2023,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Design Thinking',
                'pengarang'    => 'Jamila Baderan',
                'penerbit'     => 'Andi Offset',
                'isbn'         => '9786230107832',
                'kategori'     => 'Ilmu Sosial',
                'tahun_terbit' => 2020,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Guru Posting Berdiri Murid Update Berlari',
                'pengarang'    => 'Sumardianta',
                'penerbit'     => 'DivaPress',
                'isbn'         => '9786232937246',
                'kategori'     => 'Ilmu Sosial',
                'tahun_terbit' => 2022,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Koruptor Go To Hell',
                'pengarang'    => 'Bibit Samad',
                'penerbit'     => 'Andi Offset',
                'isbn'         => '9786230104558',
                'kategori'     => 'Ilmu Sosial',
                'tahun_terbit' => 2020,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Merdeka Belajar',
                'pengarang'    => 'Lusia Wijiatun',
                'penerbit'     => 'Andi Offset',
                'isbn'         => '9786230127915',
                'kategori'     => 'Ilmu Sosial',
                'tahun_terbit' => 2022,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Nalar Kritis',
                'pengarang'    => 'Arfan Mu\'ammar',
                'penerbit'     => 'IRCiSoD',
                'isbn'         => '9786237378037',
                'kategori'     => 'Ilmu Sosial',
                'tahun_terbit' => 2019,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Satu Ayat',
                'pengarang'    => 'M. Jusuf Kalla',
                'penerbit'     => 'Republika',
                'isbn'         => '9786027595408',
                'kategori'     => 'Ilmu Sosial',
                'tahun_terbit' => 2016,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Buya Hamka',
                'pengarang'    => 'Akmal Nasery',
                'penerbit'     => 'Republika',
                'isbn'         => '9786237458449',
                'kategori'     => 'Biografi & Sejarah',
                'tahun_terbit' => 2020,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Panggil Aku Maryam',
                'pengarang'    => 'Lesley Nazelton',
                'penerbit'     => 'IRCiSoD',
                'isbn'         => '9786237378105',
                'kategori'     => 'Biografi & Sejarah',
                'tahun_terbit' => 2020,
                'stok'         => 2,
            ],
            [
                'judul_buku'   => 'Muda Berdaya Kaya Raya',
                'pengarang'    => 'Fahd Pahdepie',
                'penerbit'     => 'Republika',
                'isbn'         => '9786025734724',
                'kategori'     => 'Teknologi',
                'tahun_terbit' => 2019,
                'stok'         => 1,
            ],
            [
                'judul_buku'   => 'Mudah Belajar Desai Grafis Dengan Aplikasi Canva',
                'pengarang'    => 'Utami Pratiwi',
                'penerbit'     => 'DivaPress',
                'isbn'         => '9786232933101',
                'kategori'     => 'Umum',
                'tahun_terbit' => 2021,
                'stok'         => 2,
            ],
        ];
    }
}