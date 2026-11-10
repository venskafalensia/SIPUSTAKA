<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('book_id')
                ->constrained('books')
                ->restrictOnDelete();

            $table->date('tanggal_pinjam');

            $table->date('tanggal_jatuh_tempo');

            $table->date('tanggal_kembali')->nullable();

            $table->integer('jumlah')->default(1);

            $table->enum('status', [
                'Dipinjam',
                'Dikembalikan',
                'Terlambat'
            ])->default('Dipinjam');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};