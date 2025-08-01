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
        Schema::create('concepts_response_transport', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('response_transport_quote_id');
            $table->unsignedBigInteger('concepts_id');
            $table->decimal('net_amount', 8, 2)->comment('Monto neto (sin IGV)');
            // Igv por concepto
            $table->decimal('igv', 12, 2)->comment('Igv por concepto'); 
            
            $table->decimal('total_sol', 12, 2)->comment('Total en soles (net_amount + igv)');
            // Suma de net_amount + igv
            $table->decimal('total_usd', 12, 2)->comment('Total en USD (con IGV)');
            // Utilidad que el usuario agregó en USD
            $table->decimal('value_utility', 12, 2)->comment('Utilidad en USD');
            // Costo de venta en USD (total_usd + utility_usd)
            $table->decimal('sale_price', 12, 2)->comment('Costo de venta en USD');
            $table->timestamps();
            // FK a response_transport_quote
            $table->foreign('response_transport_quote_id')->references('id')->on('response_transport_quotes');
            // FK a concepts
            $table->foreign('concepts_id')->references('id')->on('concepts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('concepts_response_transport');
    }
};
