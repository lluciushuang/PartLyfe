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
     Schema::create('broadcasts', function (Blueprint $table) {
         $table->id();
         $table->foreignId('user_id')->constrained()->cascadeOnDelete();
         $table->string('title');
         $table->text('message');
         $table->string('type'); // Isi: promo, system, info
         $table->boolean('is_read')->default(false); // Penanda sudah dibaca atau belum
         $table->timestamps();
     });
 }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broadcasts');
    }
};
