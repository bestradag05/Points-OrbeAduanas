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
        Schema::create('response_freight_quotes', function (Blueprint $table) {
            $table->id();
            $table->string('nro_response')->unique();
            $table->date('validity_date');
            $table->unsignedBigInteger('id_supplier');
            $table->string('airline_id')->nullable();
            $table->string('shipping_company_id')->nullable();
            $table->string('origin');
            $table->string('destination');
            $table->enum('frequency', ['Diario', 'Semanal', 'Quincenal', 'Mensual'])->nullable();
            $table->string('service')->nullable();
            $table->string('transit_time')->nullable();
            $table->string('free_days')->nullable();
            $table->string('exchange_rate')->nullable();
            $table->decimal('total', 8, 2);
            $table->unsignedBigInteger('id_quote_freight');
            $table->enum('status', ['Enviada', 'Aceptado', 'Rechazada'])->default('Enviada');
            $table->timestamps();

            $table->foreign('id_supplier')->references('id')->on('suppliers');
            $table->foreign('id_quote_freight')->references('id')->on('quote_freight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_freight_quotes');
    }
};
