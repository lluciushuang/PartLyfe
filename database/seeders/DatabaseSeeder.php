<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BIKIN AKUN
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

        // 2. BIKIN KATEGORI
        $categories = [
            'Oli & Pelumas', 'Pengapian & Kelistrikan', 'Pengereman', 
            'Mesin & Transmisi', 'Ban & Velg', 'Aksesoris & Body'
        ];
        
        foreach ($categories as $catName) {
            Category::create(['name' => $catName, 'description' => 'Kategori ' . $catName]);
        }

        // 3. GENERATE 100 PRODUK (Tanpa Persentase Hardcode)
        $faker = Faker::create('id_ID');
        $brands = ['Yamalube', 'NGK', 'Brembo', 'Motul', 'AHM', 'IRC', 'Michelin', 'YSS', 'KTC', 'Bosch', 'Denso', 'Enduro'];
        $partTypes = ['Kampas Rem', 'V-Belt', 'Filter Udara', 'Busi Iridium', 'Oli Mesin', 'Oli Gardan', 'Shockbreaker', 'Aki', 'Lampu LED', 'Rantai Roda', 'Kampas Kopling', 'Roller'];

        for ($i = 1; $i <= 100; $i++) {
            $brand = $faker->randomElement($brands);
            $type = $faker->randomElement($partTypes);
            
            // Modal awal (Misal: 25.000)
            $basePrice = $faker->numberBetween(15, 400) * 1000; 
            
            // Harga Grosir: Modal + untung random 5rb - 15rb (Misal jadi 35.000)
            $grosirPrice = $basePrice + ($faker->numberBetween(5, 15) * 1000);
            
            // Harga Eceran: Harga grosir + margin random 10rb - 35rb (Misal jadi 55.000)
            $retailPrice = $grosirPrice + ($faker->numberBetween(10, 35) * 1000);

            $product = Product::create([
                'category_id' => $faker->numberBetween(1, 6),
                'item_type' => 'barang',
                'item_code' => 'PRT-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'barcode' => $faker->unique()->ean13(),
                'name' => $brand . ' ' . $type . ' ' . $faker->bothify('??-##'),
                'brand' => $brand,
                'unit' => 'PCS',
                'base_price' => $basePrice,
                'current_stock' => $faker->numberBetween(5, 150),
            ]);

            // Insert Harga Manual (Level 1: Eceran, Level 2: Grosir)
            ProductPrice::create(['product_id' => $product->id, 'price_level' => 1, 'price' => $retailPrice]);
            ProductPrice::create(['product_id' => $product->id, 'price_level' => 2, 'price' => $grosirPrice]);
        }
    }
}