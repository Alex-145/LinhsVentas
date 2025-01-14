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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('sale_date');
            $table->decimal('total', 10, 2);
            $table->decimal('utilidad_sale', 10, 2);
            $table->enum('status_fac', ['pendiente_facturacion', 'facturado','no_aplicable'])->default('no_aplicable');
            $table->enum('estado_sale', ['habil_sale', 'anulado_sale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
