<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'judul_buku',
        'pengarang',
        'penerbit',
        'isbn',
        'kategori',
        'tahun_terbit',
        'stok',
        'sampul',
        'deskripsi',
    ];
}