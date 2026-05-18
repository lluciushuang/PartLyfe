<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            
            $table->enum('item_type', ['barang', 'rakitan', 'non_inventory', 'jasa'])->default('barang');
            $table->string('item_code')->unique(); 
            $table->string('barcode')->nullable()->unique();
            $table->string('name'); 
            $table->string('brand')->nullable(); 
            $table->string('rack_location')->nullable(); 
            $table->text('description')->nullable(); 
            
            // --- SATUAN DIBIKIN TEKS STATIS AJA ---
            $table->string('unit')->default('PCS'); 
            
            $table->decimal('base_price', 15, 2)->default(0); 
            $table->integer('min_stock')->default(0); 
            $table->integer('current_stock')->default(0); 
            $table->boolean('is_active')->default(true); 

            $table->timestamps();   
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
