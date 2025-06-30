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
        Schema::create('concepts_response_transport', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('response_transport_quote_id');
            $table->unsignedBigInteger('concepts_id');
            $table->decimal('net_amount', 8, 2)->comment('Monto neto (sin IGV)');
            $table->timestamps();
            // FK a response_transport_quote
            $table->foreign('response_transport_quote_id')->references('id')->on('response_transport_quotes');
            // FK a concepts
            $table->foreign('concepts_id')->references('id')->on('concepts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('concepts_response_transport');
    }
};
