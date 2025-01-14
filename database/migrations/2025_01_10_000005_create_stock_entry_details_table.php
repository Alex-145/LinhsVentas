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
        Schema::create('stock_entry_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_entry_id')->constrained('stock_entries')->onDelete('cascade'); // Relación con StockEntry
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Relación con productos
            $table->integer('quantity'); // Cantidad
            $table->decimal('purchase_pricedolar', 15, 2)->nullable(); // Precio de compra
            $table->decimal('purchase_pricesol', 15, 2); // Precio de compra
            $table->decimal('subtotaldolar', 15, 2)->nullable(); // Subtotal
            $table->decimal('subtotalsol', 15, 2); // Subtotal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_entry_details');
    }
};
