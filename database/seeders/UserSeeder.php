<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // AKUN ADMIN
        User::updateOrCreate(
            [
                'username' => 'admin',
            ],
            [
                'name' => 'Bu Sari',
                'email' => 'admin@sipustaka.test',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // AKUN SISWA
        User::updateOrCreate(
            [
                'username' => 'siswa',
            ],
            [
                'name' => 'Venska',
                'email' => 'siswa@sipustaka.test',
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
            ]
        );

        $this->command->info('Akun admin dan siswa berhasil disiapkan.');
    }
}