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
        Schema::create('consolidated_cargos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commercial_quote_id'); // Relación con commercial_quotes
            $table->unsignedBigInteger('supplier_id'); // Relación con shippers
            $table->json('supplier_temp')->nullable(); // JSON para shipper temporal
            $table->string('commodity', 255);
            $table->decimal('load_value', 10, 2);
            $table->integer('nro_packages');
            $table->string('packaging_type', 50);
            $table->decimal('volumen', 10, 2);
            $table->decimal('kilograms', 10, 2);
            $table->json('value_measures'); // JSON para medidas
            $table->timestamps();

            $table->foreign('commercial_quote_id')->references('id')->on('commercial_quote');
            $table->foreign('supplier_id')->references('id')->on('suppliers');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consolidated_cargos');
    }
};
