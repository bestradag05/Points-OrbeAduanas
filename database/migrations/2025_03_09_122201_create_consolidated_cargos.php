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
            $table->unsignedBigInteger('supplier_id')->nullable(); // Relación con shippers
            $table->json('supplier_temp')->nullable(); // JSON para shipper temporal
            $table->string('commodity', 255);
            $table->decimal('load_value', 10, 2);
            $table->integer('nro_packages');
            $table->unsignedBigInteger('id_packaging_type');
            $table->unsignedBigInteger('id_incoterms');
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('unit_of_weight')->nullable();
            $table->decimal('volumen_kgv', 8, 2)->nullable();
            $table->string('unit_of_volumen_kgv')->nullable();
            $table->json('value_measures')->nullable(); // JSON para medidas
            $table->timestamps();

            $table->foreign('commercial_quote_id')->references('id')->on('commercial_quote');
            $table->foreign('id_incoterms')->references('id')->on('incoterms');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('id_packaging_type')->references('id')->on('packing_types');
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
