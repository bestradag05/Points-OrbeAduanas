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
        Schema::create('response_transport_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_transport_id')->constrained('quote_transport');
            $table->string('nro_response')->unique()->default('');
            $table->foreignId('provider_id')->constrained('suppliers');
            $table->string('type_vehicle', 100)->nullable();
            // Costo que el proveedor factura en S/.
            $table->decimal('provider_cost', 12, 2)->comment('Costo total en soles facturado por el proveedor');
            $table->decimal('total_sol', 12, 2)->comment('Total en soles (provider_cost + igv)');
            // Tipo de cambio utilizado para convertir soles a USD
            $table->decimal('exchange_rate', 8, 4)->nullable()->comment('Tipo de cambio S/. → US$');
            // Suma de todas las utilidades (USD) ingresadas por concepto
            $table->decimal('value_utility', 12, 2)->nullable()->comment('Suma de utilidades en US$ de todos los conceptos');
            // Total final en USD (provider_cost + value_utility)
            $table->decimal('total_usd', 12, 2)->comment('Total en US$ (total + igv ÷ tipo de cambio)');
            // Total suma de los “sale_price” de cada concepto (USD)
            $table->decimal('total_prices_usd', 12, 2)->comment('Total en US$ + utilidades');
            $table->enum('status', ['Aceptado', 'Rechazada', 'Enviada'])->default('Enviada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.  
     */
    public function down(): void
    {
        Schema::dropIfExists('response_transport_quotes');
    }
};
