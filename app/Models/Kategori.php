<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $fillable = ['nama', 'deskripsi'];

    // books.kategori menyimpan NAMA kategori (string), jadi relasinya lewat kolom nama
    public function books()
    {
        return $this->hasMany(Book::class, 'kategori', 'nama');
    }
}