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
    Schema::create('quote_traces', function (Blueprint $table) {
        $table->id();

        $table->foreignId('quote_id')->constrained('quote_transport'); // FK hacia transporte (por ahora)
        $table->foreignId('response_id')->nullable()->constrained('response_transport_quotes'); // opcional
        $table->enum('service_type', ['aduana', 'flete', 'transporte']);
        $table->enum('action', ['Aceptado', 'Confirmada', 'Rechazada', 'Enviada']);
        $table->text('justification')->nullable();
        $table->foreignId('user_id')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_traces');
    }
};
