<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambahkan kolom cashback_percent, default 0 (berarti tidak ada cashback)
            $table->integer('cashback_percent')->default(0)->after('current_stock');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('cashback_percent');
        });
    }
};
