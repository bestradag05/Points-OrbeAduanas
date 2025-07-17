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
            $table->unsignedBigInteger('commercial_quote_id');
            $table->enum('status', ['Pendiente', 'Aceptado', 'Rechazado'])->default('Pendiente');
            $table->timestamps();

            $table->foreign('commercial_quote_id')->references('id')->on('commercial_quote');
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
