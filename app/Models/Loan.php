<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    /**
     * Batas total buku yang boleh dipinjam seorang siswa pada satu waktu
     * (pengajuan yang menunggu + pinjaman yang belum dikembalikan).
     */
    public const KUOTA_MAKS = 5;

    /**
     * Status yang masih menghitung kuota.
     */
    public const STATUS_AKTIF = ['Menunggu', 'Dipinjam', 'Terlambat'];

    /**
     * Kolom yang boleh diisi melalui Loan::create()
     * dan operasi mass assignment lainnya.
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'jumlah',
        'status',
    ];

    /**
     * Konversi kolom tanggal.
     */
    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_jatuh_tempo' => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    /**
     * Pinjaman/pengajuan yang masih aktif (belum dikembalikan).
     */
    public function scopeAktif($query)
    {
        return $query->whereNull('tanggal_kembali')
            ->whereIn('status', self::STATUS_AKTIF);
    }

    /**
     * Jumlah buku yang sedang dipakai siswa (menunggu + dipinjam + terlambat).
     */
    public static function kuotaTerpakai(int $userId): int
    {
        return (int) static::aktif()->where('user_id', $userId)->sum('jumlah');
    }

    /**
     * Sisa buku yang masih boleh dipinjam siswa.
     */
    public static function sisaKuota(int $userId): int
    {
        return max(0, self::KUOTA_MAKS - self::kuotaTerpakai($userId));
    }

    /**
     * Relasi peminjaman dengan anggota/siswa.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi peminjaman dengan buku.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}