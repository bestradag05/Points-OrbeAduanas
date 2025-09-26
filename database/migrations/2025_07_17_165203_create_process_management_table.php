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
        Schema::create('process_management', function (Blueprint $table) {
            $table->id();
            $table->string('nro_quote_commercial');
            $table->enum('freight_status', ['Pendiente', 'En Proceso', 'Completado'])->nullable();
            $table->enum('customs_status', ['Pendiente', 'En Proceso', 'Completado'])->nullable();
            $table->enum('transport_status', ['Pendiente', 'En Proceso', 'Completado'])->nullable();
            $table->enum('status', ['Pendiente', 'En Proceso', 'Anulado', 'Enviado', 'Completado'])->default('Pendiente');
            $table->boolean('process_completed')->default(false);
            $table->timestamps();

             $table->foreign('nro_quote_commercial')->references('nro_quote_commercial')->on('quotes_sent_clients')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_management');
    }
};
