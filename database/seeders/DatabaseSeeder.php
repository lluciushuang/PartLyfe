<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BIKIN AKUN (Tetap dipertahankan biar kamu bisa login)
        User::create([
            'name' => 'Lennard (Admin)',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('pass'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pelanggan Eceran',
            'email' => 'cus@gmail.com',
            'password' => Hash::make('pass'),
            'role' => 'b2c',
        ]);

        // 2. PANGGIL PRODUCT SEEDER (Untuk eksekusi 30 produk nyata + gambar)
        $this->call(ProductSeeder::class);
    }
}