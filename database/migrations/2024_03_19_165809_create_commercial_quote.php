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
        Schema::create('commercial_quote', function (Blueprint $table) {
            $table->id();
            $table->string('nro_quote_commercial')->unique();
            $table->string('origin');
            $table->string('destination');
            $table->string('customer_ruc')->nullable();
            $table->string('customer_company_name')->nullable();
            $table->decimal('load_value', 8, 2);
            $table->unsignedBigInteger('id_personal');
            $table->unsignedBigInteger('id_type_shipment');
            $table->unsignedBigInteger('id_regime');
            $table->unsignedBigInteger('id_incoterms');
            $table->unsignedBigInteger('id_type_load');
            $table->string('lcl_fcl')->nullable();
            $table->boolean('is_consolidated')->nullable();
            $table->string('commodity')->nullable();
            $table->string('nro_package')->nullable();
            $table->string('packaging_type')->nullable();
            $table->string('container_type')->nullable();
            $table->decimal('kilograms', 8, 2)->nullable();
            $table->decimal('volumen', 8, 2)->nullable();
            $table->decimal('kilogram_volumen', 8, 2)->nullable();
            $table->decimal('tons', 8, 2)->nullable();
            $table->text('measures')->nullable();
            $table->decimal('cif_value', 8 , 2)->nullable();
            $table->string('observation')->nullable();
            $table->enum('state', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial_quote');
    }
};
