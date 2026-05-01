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
            Schema::create('product_uoms', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('uom_name'); // Contoh: 'Box', 'Karton'
                $table->decimal('conversion_factor', 10, 2); // Contoh: 1 Box = 10 Pcs (isi 10)
                $table->decimal('price', 15, 2); // Harga khusus untuk satuan ini
                $table->string('barcode')->nullable(); // Barcode khusus untuk Box/Karton
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_oums');
    }
};
