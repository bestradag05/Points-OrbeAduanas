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
        Schema::create('response_transport_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_transport_id')->constrained('quote_transport');
            $table->string('nro_response')->unique()->default('');
            $table->foreignId('provider_id')->constrained('suppliers');
            $table->decimal('provider_cost', 12, 2);
            $table->decimal('commission', 12, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->enum('status', ['Aceptado', 'Confirmada', 'Rechazada', 'Enviada'])->default('Enviada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.  
     */
    public function down(): void
    {
        Schema::dropIfExists('response_transport_quotes');
    }
};
