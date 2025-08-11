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
        Schema::create('custom', function (Blueprint $table) {
            $table->id();
            $table->string('nro_operation_custom')->unique();
            $table->string('nro_dua')->nullable();
            $table->string('nro_dam')->nullable();
            $table->date('date_register')->nullable();
            $table->decimal('cif_value', 8, 2)->nullable();
            $table->string('channel')->nullable();
            $table->string('nro_bl')->nullable();
            $table->decimal('customs_taxes', 8, 2)->nullable();
            $table->decimal('customs_perception', 8, 2)->nullable();
            $table->decimal('value_utility', 8, 2)->nullable();
            $table->decimal('net_amount', 8, 2)->nullable();
            $table->decimal('sub_total_value_sale', 8, 2)->nullable();
            $table->decimal('igv', 8, 2)->nullable();
            $table->decimal('value_sale', 8, 2)->nullable();
            $table->decimal('profit', 8, 2)->nullable();
            $table->string('regularization_date')->nullable();
            $table->enum('state', ['Pendiente', 'Aceptado', 'Anulado', 'Rechazado'])->default('Pendiente');
            $table->unsignedBigInteger('id_modality')->nullable();
            /* $table->unsignedBigInteger('id_insurance')->nullable(); */
            $table->string('nro_quote_commercial');
            $table->timestamps();

            $table->foreign('nro_quote_commercial')->references('nro_quote_commercial')->on('commercial_quote');
            $table->foreign('id_modality')->references('id')->on('modality');
            /* $table->foreign('id_insurance')->references('id')->on('insurance'); */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom');
    }
};
