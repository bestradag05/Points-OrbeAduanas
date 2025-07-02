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
            $table->string('validity_date');
            $table->unsignedBigInteger('id_supplier');
            $table->string('origin');
            $table->string('destination');
            $table->enum('frequency', ['Diario', 'Semanal', 'Quincenal', 'Mensual']);
            $table->string('service');
            $table->string('transit_time');
            $table->string('exchange_rate')->nullable();
            $table->timestamps();

             $table->foreign('id_supplier')->references('id')->on('suppliers');
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
