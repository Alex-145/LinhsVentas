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
        Schema::table('users', function (Blueprint $table) {
            $table->string('dni', 8)->unique()->nullable(); // Agregar DNI (8 caracteres)
            $table->string('numero_celular', 15)->nullable(); // Agregar número de celular
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['dni', 'numero_celular']); // Eliminar columnas en caso de rollback
        });
    }
};
