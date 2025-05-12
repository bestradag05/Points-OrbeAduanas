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
        Schema::create('quote_transport_response', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_transport_id');
            $table->unsignedBigInteger('response_quote_id');

            // constraint con nombres cortos
            $table->foreign('quote_transport_id', 'fk_qtr_qt')
                  ->references('id')->on('quote_transport')
                  ->onDelete('cascade');

            $table->foreign('response_quote_id', 'fk_qtr_rsp')
                  ->references('id')->on('response_transport_quotes')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_transport_response');
    }
};
