<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Isi awal: 6 kategori yang sudah ada di form buku + kategori yang sudah dipakai buku
        $awal = ['Teknologi', 'Novel', 'Sains', 'Bahasa', 'Pendidikan', 'Pengembangan Diri'];
        $dariBuku = DB::table('books')->whereNotNull('kategori')->where('kategori', '!=', '')->distinct()->pluck('kategori')->all();
        foreach (array_unique(array_merge($awal, $dariBuku)) as $nama) {
            DB::table('kategoris')->insertOrIgnore(['nama' => $nama, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
    public function down(): void { Schema::dropIfExists('kategoris'); }
};