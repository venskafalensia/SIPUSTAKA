<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration users yang kamu kirim belum punya username & role, padahal halaman pencarian menampilkannya.
// Migration ini aman: hanya menambah kolom kalau belum ada. Lewati kalau sudah ada di migration lain.
return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('anggota')->after('password');
            }
        });
    }
    public function down(): void {}
};