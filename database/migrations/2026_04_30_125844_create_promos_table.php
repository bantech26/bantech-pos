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
        Schema::create('promos', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: "Promo Grand Opening B2G1"
        $table->string('type'); // B2G1, B1G1, atau DISCOUNT
        $table->string('sku');  // SKU produk yang dipromokan
        $table->integer('threshold'); // Minimal beli (contoh: 2)
        $table->integer('bonus_qty'); // Bonus yang didapat (contoh: 1)
        $table->boolean('is_active')->default(true);
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
