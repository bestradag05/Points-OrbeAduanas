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
        Schema::create('commercialquote_typeservice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_commercial_quote');
            $table->unsignedBigInteger('id_type_service');
            $table->timestamps();

            $table->foreign('id_commercial_quote')->references('id')->on('commercial_quote');
            $table->foreign('id_type_service')->references('id')->on('type_service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercialquote_typeservice');
    }
};
