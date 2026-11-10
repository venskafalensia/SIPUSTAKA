<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE loans
            MODIFY status
            ENUM(
                'Menunggu',
                'Dipinjam',
                'Dikembalikan',
                'Terlambat'
            )
            NOT NULL DEFAULT 'Dipinjam'
        ");
    }

    public function down(): void
    {
        // Jangan menghapus status Menunggu jika masih digunakan.
        DB::statement("
            UPDATE loans
            SET status = 'Dipinjam'
            WHERE status = 'Menunggu'
        ");

        DB::statement("
            ALTER TABLE loans
            MODIFY status
            ENUM(
                'Dipinjam',
                'Dikembalikan',
                'Terlambat'
            )
            NOT NULL DEFAULT 'Dipinjam'
        ");
    }
};