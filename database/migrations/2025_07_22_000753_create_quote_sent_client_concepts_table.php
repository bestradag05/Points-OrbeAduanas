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
        Schema::create('quote_sent_client_concepts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_sent_client_id');  // Relación con CodeSendClient
            $table->unsignedBigInteger('concept_id');  // Relación con la tabla de conceptos
            $table->decimal('concept_value', 8, 2);  // Valor del concepto al momento de la cotización
            $table->string('observation')->nullable();  // Valor del concepto al momento de la cotización
            $table->boolean('has_igv')->default(false);
            $table->enum('service_type', ['Flete', 'Aduanas', 'Transporte']);  // Tipo de servicio
            $table->timestamps();

            $table->foreign('quote_sent_client_id')->references('id')->on('quotes_sent_clients');
            $table->foreign('concept_id')->references('id')->on('concepts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_sent_client_concepts');
    }
};
