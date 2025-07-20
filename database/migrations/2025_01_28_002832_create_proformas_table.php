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
        Schema::create('proformas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('codigo')->unique();
            $table->enum('factura', ['si', 'no']);
            $table->enum('status', [
                'solocotizacion',
                'esperando_pago',
                'esperando_verificacion',
                'pagado',
                'cerrado',
                'cerrado_por_vencimiento',
                'cancelado'
            ])->default('solocotizacion');
            $table->date('fecha_vencimiento');
            $table->decimal('total', 15, 2);

            // Nuevos campos
            $table->string('metodo_pago')->nullable();
            $table->boolean('correo_notificado')->default(false); // Si se notificó al cliente
            $table->datetime('fecha_pago')->nullable();
            $table->datetime('fecha_confirmacion')->nullable();
            $table->string('comprobante_url')->nullable(); // Ruta del archivo del comprobante
            $table->boolean('convertido_a_venta')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proformas');
    }
};
