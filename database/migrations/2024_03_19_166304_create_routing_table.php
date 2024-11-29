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
        Schema::create('routing', function (Blueprint $table) {
            $table->id();
            $table->string('nro_operation')->unique();
            $table->string('origin');
            $table->string('destination');
            $table->decimal('load_value', 8, 2);
            $table->decimal('insurance_value', 8, 2)->nullable();
            $table->unsignedBigInteger('id_personal');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_type_shipment');
            $table->unsignedBigInteger('id_regime');
            $table->unsignedBigInteger('id_incoterms');
            $table->unsignedBigInteger('id_supplier');
            $table->unsignedBigInteger('id_type_load');
            $table->string('lcl_fcl')->nullable();
            $table->string('commodity');
            $table->string('nro_package')->nullable();
            $table->string('packaging_type')->nullable();
            $table->decimal('pounds', 8, 2)->nullable();
            $table->decimal('kilograms', 8, 2)->nullable();
            $table->decimal('volumen', 8, 2)->nullable();
            $table->decimal('kilogram_volumen', 8, 2)->nullable();
            $table->string('hs_code')->nullable();
            $table->string('observation')->nullable();
            $table->string('concepts')->nullable();
            $table->timestamps();


            $table->foreign('id_personal')->references('id')->on('personal');
            $table->foreign('id_customer')->references('id')->on('customer');
            $table->foreign('id_type_shipment')->references('id')->on('type_shipment');
            $table->foreign('id_regime')->references('id')->on('regime');
            $table->foreign('id_incoterms')->references('id')->on('incoterms');
            $table->foreign('id_supplier')->references('id')->on('suppliers');
            $table->foreign('id_type_load')->references('id')->on('type_load');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routing');
    }
};
