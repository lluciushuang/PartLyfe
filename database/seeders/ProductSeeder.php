<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductPrice;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Bersihkan database lama agar fresh
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductImage::truncate();
        ProductPrice::truncate();
        Product::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Buat Kategori Suku Cadang 
        $categories = [
            'Pengereman' => Category::create(['name' => 'Pengereman', 'description' => 'Kategori Pengereman']),
            'Kelistrikan' => Category::create(['name' => 'Kelistrikan', 'description' => 'Kategori Kelistrikan']),
            'Kaki-Kaki & Roda' => Category::create(['name' => 'Kaki-Kaki & Roda', 'description' => 'Kategori Kaki-Kaki & Roda']),
            'Mesin & Penggerak' => Category::create(['name' => 'Mesin & Penggerak', 'description' => 'Kategori Mesin & Penggerak']),
            'Oli & Pelumas' => Category::create(['name' => 'Oli & Pelumas', 'description' => 'Kategori Oli & Pelumas']),
        ];

        // 2. Data Master 30 Sparepart
        $spareparts = [
            // Pengereman
            ['name' => 'Kampas Rem Depan Vario / Beat FI', 'brand' => 'AHM', 'item_code' => 'PRT-001', 'stock' => 50, 'cat' => 'Pengereman', 'price' => 55000, 'img' => ['products/kampas-depan-1.png', 'products/kampas-depan-detail.png']],
            ['name' => 'Kampas Rem Belakang NMAX / Aerox', 'brand' => 'YGP', 'item_code' => 'PRT-002', 'stock' => 45, 'cat' => 'Pengereman', 'price' => 65000, 'img' => ['products/kampas-nmax.png']],
            ['name' => 'Piringan Cakram Depan Supra X 125', 'brand' => 'Aspira', 'item_code' => 'PRT-003', 'stock' => 20, 'cat' => 'Pengereman', 'price' => 125000, 'img' => ['products/cakram-supra.png']],
            ['name' => 'Master Rem Atas Kanan Universal', 'brand' => 'Choho', 'item_code' => 'PRT-004', 'stock' => 15, 'cat' => 'Pengereman', 'price' => 175000, 'img' => ['products/master-rem.png']],
            ['name' => 'Kabel Rem Belakang Mio Karbu', 'brand' => 'Federal', 'item_code' => 'PRT-005', 'stock' => 30, 'cat' => 'Pengereman', 'price' => 35000, 'img' => ['products/kabel-rem.png']],
            ['name' => 'Caliper Rem Bawah Belakang Satria FU', 'brand' => 'MPM', 'item_code' => 'PRT-006', 'stock' => 8, 'cat' => 'Pengereman', 'price' => 210000, 'img' => ['products/caliper.png']],

            // Kelistrikan
            ['name' => 'Busi Racing Iridium Power IU22', 'brand' => 'NGK', 'item_code' => 'PRT-007', 'stock' => 120, 'cat' => 'Kelistrikan', 'price' => 95000, 'img' => ['products/busi-iridium.png', 'products/busi-box.png']],
            ['name' => 'Aki Kering MF GTZ5S Super Power', 'brand' => 'Max1', 'item_code' => 'PRT-008', 'stock' => 25, 'cat' => 'Kelistrikan', 'price' => 185000, 'img' => ['products/aki-gtz5s.png']],
            ['name' => 'Kiprok Regulator Karisma / Supra X', 'brand' => 'Federal', 'item_code' => 'PRT-009', 'stock' => 18, 'cat' => 'Kelistrikan', 'price' => 75000, 'img' => ['products/kiprok.png']],
            ['name' => 'CDI Racing Unlimiter Jupiter Z Lama', 'brand' => 'Tenshi', 'item_code' => 'PRT-010', 'stock' => 12, 'cat' => 'Kelistrikan', 'price' => 160000, 'img' => ['products/cdi-racing.png']],
            ['name' => 'Bohlam Lampu Depan LED H4 Kaki 3', 'brand' => 'Thai', 'item_code' => 'PRT-011', 'stock' => 60, 'cat' => 'Kelistrikan', 'price' => 48000, 'img' => ['products/led-h4.png']],
            ['name' => 'Spool Stator Assy Grand / Prima', 'brand' => 'NPP', 'item_code' => 'PRT-012', 'stock' => 10, 'cat' => 'Kelistrikan', 'price' => 115000, 'img' => ['products/spool.png']],

            // Kaki-Kaki & Roda
            ['name' => 'Ban Luar Tubeless Green Devil 90/80-14', 'brand' => 'Maxxis', 'item_code' => 'PRT-013', 'stock' => 40, 'cat' => 'Kaki-Kaki & Roda', 'price' => 255000, 'img' => ['products/maxxis-devil.png', 'products/maxxis-tread.png']],
            ['name' => 'Ban Luar NR73 Tube Type 80/90-17', 'brand' => 'IRC', 'item_code' => 'PRT-014', 'stock' => 35, 'cat' => 'Kaki-Kaki & Roda', 'price' => 178000, 'img' => ['products/irc-nr73.png']],
            ['name' => 'Shockbreaker Belakang Pro-Series 330mm', 'brand' => 'Aspira', 'item_code' => 'PRT-015', 'stock' => 14, 'cat' => 'Kaki-Kaki & Roda', 'price' => 295000, 'img' => ['products/shock-aspira.png', 'products/shock-box.png']],
            ['name' => 'V-Belt Kit + Roller Vario 110 Karbu', 'brand' => 'MPM', 'item_code' => 'PRT-016', 'stock' => 22, 'cat' => 'Kaki-Kaki & Roda', 'price' => 135000, 'img' => ['products/vbelt-vario.png']],
            ['name' => 'Gear Set Paket Rantai Supra Fit New', 'brand' => 'Choho', 'item_code' => 'PRT-017', 'stock' => 16, 'cat' => 'Kaki-Kaki & Roda', 'price' => 165000, 'img' => ['products/gearset.png']],
            ['name' => 'Laher Bearing Roda Depan 6301 ZZ', 'brand' => 'NPP', 'item_code' => 'PRT-018', 'stock' => 80, 'cat' => 'Kaki-Kaki & Roda', 'price' => 18000, 'img' => ['products/bearing.png']],

            // Mesin & Penggerak
            ['name' => 'Piston Kit Bore Up diameter 58mm', 'brand' => 'NPP', 'item_code' => 'PRT-019', 'stock' => 25, 'cat' => 'Mesin & Penggerak', 'price' => 155000, 'img' => ['products/piston-kit.png', 'products/piston-detail.png']],
            ['name' => 'Karburator Assy Black PE 28 Racing', 'brand' => 'Mikuni', 'item_code' => 'PRT-020', 'stock' => 9, 'cat' => 'Mesin & Penggerak', 'price' => 340000, 'img' => ['products/karbu-pe28.png']],
            ['name' => 'Blok Cylinder Set Standar Grand', 'brand' => 'Federal', 'item_code' => 'PRT-021', 'stock' => 6, 'cat' => 'Mesin & Penggerak', 'price' => 265000, 'img' => ['products/blok-silinder.png']],
            ['name' => 'Noken As Camshaft Racing Mio Karbu', 'brand' => 'Tenshi', 'item_code' => 'PRT-022', 'stock' => 15, 'cat' => 'Mesin & Penggerak', 'price' => 125000, 'img' => ['products/noken-as.png']],
            ['name' => 'Kampas Kopling Ganda Matic Beat FI', 'brand' => 'AHM', 'item_code' => 'PRT-023', 'stock' => 0, 'cat' => 'Mesin & Penggerak', 'price' => 115000, 'img' => ['products/kopling-ganda.png']],
            ['name' => 'Stang Seher Connecting Rod Legenda', 'brand' => 'NPP', 'item_code' => 'PRT-024', 'stock' => 0, 'cat' => 'Mesin & Penggerak', 'price' => 105000, 'img' => ['products/stang-seher.png']],

            // Oli & Pelumas
            ['name' => 'Oli Mesin MPX 2 Matic 10W-30 0.8L', 'brand' => 'AHM', 'item_code' => 'PRT-025', 'stock' => 150, 'cat' => 'Oli & Pelumas', 'price' => 54000, 'img' => ['products/oli-mpx2.png']],
            ['name' => 'Oli Mesin Yamalube Super Matic 1L', 'brand' => 'YGP', 'item_code' => 'PRT-026', 'stock' => 90, 'cat' => 'Oli & Pelumas', 'price' => 70000, 'img' => ['products/oli-yamalube.png']],
            ['name' => 'Oli Samping 2T Premium Low Smoke 1L', 'brand' => 'Thai', 'item_code' => 'PRT-027', 'stock' => 40, 'cat' => 'Oli & Pelumas', 'price' => 45000, 'img' => ['products/oli-2t.png']],
            ['name' => 'Minyak Rem DOT 4 Super Brake Fluid', 'brand' => 'MPM', 'item_code' => 'PRT-028', 'stock' => 55, 'cat' => 'Oli & Pelumas', 'price' => 28000, 'img' => ['products/minyak-rem.png']],
            ['name' => 'Oli Gardan Gear Oil Matic 120ml', 'brand' => 'Aspira', 'item_code' => 'PRT-029', 'stock' => 110, 'cat' => 'Oli & Pelumas', 'price' => 17000, 'img' => ['products/oli-gardan.png']],
            ['name' => 'Air Radiator Coolant Super Long Life', 'brand' => 'AHM', 'item_code' => 'PRT-030', 'stock' => 0, 'cat' => 'Oli & Pelumas', 'price' => 24000, 'img' => ['products/coolant.png']],
        ];

        foreach ($spareparts as $key => $item) {
            // MENYESUAIKAN KOLOM WAJIB BAWAN MIGRATION KAMU BIAR TIDAK ERROR
            $product = Product::create([
                'category_id' => $categories[$item['cat']]->id,
                'item_type' => 'barang',
                'item_code' => $item['item_code'],
                // SIHIR BARU: Kombinasi waktu + index key + random, dijamin anti-kembar sedunia!
                'barcode' => '899' . time() . $key . rand(100, 999), 
                'name' => $item['name'],
                'brand' => $item['brand'],
                'unit' => 'PCS',
                'base_price' => $item['price'] * 0.8, // Otomatis hitung harga modal awal (80% dari eceran)
                'current_stock' => $item['stock'],
                'cashback_percent' => 0,
            ]);

            // Simpan harga eceran (Level 1)
            ProductPrice::create([
                'product_id' => $product->id,
                'price_level' => 1,
                'price' => $item['price']
            ]);
            
            // Simpan harga grosir (Level 2 - Otomatis lebih murah sedikit dari eceran)
            ProductPrice::create([
                'product_id' => $product->id,
                'price_level' => 2,
                'price' => $item['price'] * 0.9
            ]);

            // Simpan relasi banyak gambar
            foreach ($item['img'] as $path) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }
    }
}