<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name', 'description'];

    // Relasi: 1 Kategori punya Banyak Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
