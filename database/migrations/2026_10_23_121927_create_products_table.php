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
        $table->string('sku')->unique(); // Kode unik / SKU produk
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('purchase_price', 12, 2); // Harga Beli (Modal)
        $table->decimal('selling_price', 12, 2);  // Harga Jual
        $table->integer('stock'); // Jumlah stok barang
        $table->string('image')->nullable(); // Foto produk
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