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
        Schema::create('concepts_customs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_concepts');
            $table->unsignedBigInteger('id_customs');
            $table->decimal('value_concept', 8 , 2);
            $table->timestamps();

            $table->foreign('id_concepts')->references('id')->on('concepts');
            $table->foreign('id_customs')->references('id')->on('custom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concepts_customs');
    }
};
