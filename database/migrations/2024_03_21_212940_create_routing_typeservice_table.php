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
        Schema::create('routing_typeservice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_routing');
            $table->unsignedBigInteger('id_type_service');
            $table->timestamps();

            $table->foreign('id_routing')->references('id')->on('routing');
            $table->foreign('id_type_service')->references('id')->on('type_service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routing_typeservice');
    }
};
