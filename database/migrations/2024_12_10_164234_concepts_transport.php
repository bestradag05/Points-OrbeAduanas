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
        Schema::create('concepts_transport', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('concepts_id');
            $table->decimal('added_value', 8, 2)->comment('Valor adicional aplicado');
            $table->decimal('net_amount_response', 10, 2)->nullable()->comment('Valor base del proveedor, desde concepts_response');
            $table->decimal('subtotal', 10, 2)->nullable()->comment('Suma de net_amount_response + added_value');
            $table->decimal('igv', 8, 2)->comment('Impuesto aplicado');
            $table->decimal('total', 8, 2)->comment('Total (net_amount + igv)');
            $table->integer('additional_points');
            $table->timestamps();
            // FK a transport
            $table->foreign('transport_id')->references('id')->on('transport');
            // FK a concepts
            $table->foreign('concepts_id')->references('id')->on('concepts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concepts_transport');
    }
};
