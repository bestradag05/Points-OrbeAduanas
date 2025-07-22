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
        Schema::create('quotes_sent_clients', function (Blueprint $table) {
            $table->id();
            $table->string('nro_quote_commercial')->unique();

            /* Datos que se replicaran en la cotizacion enviada al cliente */

            $table->unsignedBigInteger('origin');
            $table->unsignedBigInteger('destination');
            $table->string('customer_company_name')->nullable();
            $table->decimal('load_value', 8, 2);
            $table->unsignedBigInteger('id_personal');
            $table->unsignedBigInteger('id_type_shipment');
            $table->unsignedBigInteger('id_regime');
            $table->unsignedBigInteger('id_incoterms');
            $table->unsignedBigInteger('id_type_load');
            $table->unsignedBigInteger('id_customer')->nullable();
            $table->unsignedBigInteger('id_supplier')->nullable();
            $table->string('lcl_fcl')->nullable();
            $table->boolean('is_consolidated')->nullable();
            $table->string('commodity')->nullable();
            $table->string('nro_package')->nullable();
            $table->unsignedBigInteger('id_packaging_type')->nullable();
            $table->decimal('kilograms', 8, 2)->nullable();
            $table->decimal('volumen', 8, 2)->nullable();
            $table->decimal('pounds', 8, 2)->nullable();
            $table->decimal('kilogram_volumen', 8, 2)->nullable();
            $table->decimal('tons', 8, 2)->nullable();
            $table->text('measures')->nullable();
            $table->decimal('cif_value', 8 , 2)->nullable();
            $table->date('valid_date')->nullable();


            $table->unsignedBigInteger('commercial_quote_id');
            $table->enum('status', ['Pendiente', 'Aceptado', 'Rechazado', 'Caducado', 'Anulado'])->default('Pendiente');
            $table->timestamps();

            $table->foreign('commercial_quote_id')->references('id')->on('commercial_quote');

            $table->foreign('origin')->references('id') ->on('state_country');
            $table->foreign('destination')->references('id') ->on('state_country');
            $table->foreign('id_customer')->references('id') ->on('customer');
            $table->foreign('id_supplier')->references('id') ->on('suppliers');
            $table->foreign('id_personal')->references('id')->on('personal');
            $table->foreign('id_type_shipment')->references('id')->on('type_shipment');
            $table->foreign('id_regime')->references('id')->on('regime');
            $table->foreign('id_incoterms')->references('id')->on('incoterms');
            $table->foreign('id_type_load')->references('id')->on('type_load');
            $table->foreign('id_packaging_type')->references('id')->on('packing_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes_sent_clients');
    }
};
