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
        Schema::create('concepts_transport', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('concepts_id');
            $table->decimal('response_value', 8, 2);
            $table->decimal('value_concept', 8, 2);
            $table->timestamps();
            // FK a transport
            $table->foreign('transport_id')->references('id')->on('transport');
            // FK a concepts
            $table->foreign('concepts_id')->references('id')->on('concepts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concepts_transport');
    }
};
