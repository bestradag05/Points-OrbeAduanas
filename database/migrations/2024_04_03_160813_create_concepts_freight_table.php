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
        Schema::create('concepts_freight', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_concepts');
            $table->unsignedBigInteger('id_freight');
            $table->decimal('value_concept', 8 , 2);
            $table->decimal('value_concept_added', 8 , 2);
            $table->decimal('total_value_concept', 8 , 2);
            $table->integer('additional_points')->nullable();
            $table->timestamps();

            $table->foreign('id_concepts')->references('id')->on('concepts');
            $table->foreign('id_freight')->references('id')->on('freight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concepts_freight');
    }
};
