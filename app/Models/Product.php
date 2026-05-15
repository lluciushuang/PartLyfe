<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Kita pakai $guarded = ['id'] sebagai pengganti $fillable.
    // Tujuannya biar semua data dari seeder bisa otomatis masuk 
    // tanpa harus kita ketik nama kolomnya satu per satu.
    protected $guarded = ['id'];

    // Relasi 1: 1 Produk punya 1 Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // --- INI RELASI YANG BARU ---
    // Relasi 2: 1 Produk punya Banyak Level Harga (Retail & Grosir)
    // Relasi ini yang dicari oleh ->with('prices') di routes/web.php tadi
    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }
}