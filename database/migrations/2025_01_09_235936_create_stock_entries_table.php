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
        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade'); // Relación con la tabla suppliers
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla users
            $table->date('reception_date'); // Fecha de recepción
            $table->decimal('total_dollar', 15, 2)->nullable();; // Total
            $table->enum('currency', ['sol', 'dolar']); // Moneda
            $table->decimal('dollar_value', 15, 2)->nullable(); // Valor del dólar (nullable)
            $table->decimal('total_soles', 15, 2); // Total en soles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_entries');
    }
};
