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
            $table->string('customer_company_name')->nullable();
            $table->decimal('load_value', 8, 2);
            $table->unsignedBigInteger('id_personal');
            $table->unsignedBigInteger('id_type_shipment');
            $table->unsignedBigInteger('id_regime');
            $table->unsignedBigInteger('id_incoterms');
            $table->unsignedBigInteger('id_type_load');
            $table->unsignedBigInteger('id_customer')->nullable();
            $table->unsignedBigInteger('id_supplier')->nullable();
            $table->unsignedBigInteger('id_containers')->nullable();
            $table->integer('container_quantity')->nullable();
            $table->string('lcl_fcl')->nullable();
            $table->boolean('is_consolidated')->nullable();
            /* Si es consolidado */
            $table->integer('total_nro_package_consolidated')->nullable();
            $table->decimal('total_volumen_consolidated')->nullable();
            $table->decimal('total_kilogram_consolidated')->nullable();
            $table->decimal('total_kilogram_volumen_consolidated')->nullable();

            /* Fin si es consolidado */

            $table->string('commodity')->nullable();
            $table->string('nro_package')->nullable();
            $table->string('packaging_type')->nullable();
            $table->decimal('kilograms', 8, 2)->nullable();
            $table->decimal('volumen', 8, 2)->nullable();
            $table->decimal('pounds', 8, 2)->nullable();
            $table->decimal('kilogram_volumen', 8, 2)->nullable();
            $table->decimal('tons', 8, 2)->nullable();
            $table->text('measures')->nullable();
            $table->decimal('cif_value', 8 , 2)->nullable();
            $table->date('valid_date')->nullable();
            $table->enum('state', ['Pendiente', 'Inactivo', 'Aceptado', 'Rechazado', 'Sin respuesta'])->default('Pendiente');
            $table->timestamps();

            $table->foreign('id_customer')->references('id') ->on('customer');
            $table->foreign('id_supplier')->references('id') ->on('suppliers');
            $table->foreign('id_containers')->references('id') ->on('containers');
            $table->foreign('id_personal')->references('id')->on('personal');
            $table->foreign('id_type_shipment')->references('id')->on('type_shipment');
            $table->foreign('id_regime')->references('id')->on('regime');
            $table->foreign('id_incoterms')->references('id')->on('incoterms');
            $table->foreign('id_type_load')->references('id')->on('type_load');


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
