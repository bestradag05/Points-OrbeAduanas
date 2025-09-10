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
        Schema::create('concepts_response_freight', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('response_freight_id');
            $table->unsignedBigInteger('concept_id');
            $table->unsignedBigInteger('currency_id');
            $table->decimal('unit_cost', 8, 2);
            $table->decimal('igv', 8, 2);
            $table->string('fixed_miltiplyable_cost')->nullable();
            $table->string('observations')->nullable();
            $table->decimal('final_cost', 8, 2);
            $table->boolean('has_igv')->default(false);
            $table->timestamps();

            $table->foreign('response_freight_id')->references('id')->on('response_freight_quotes');
            $table->foreign('concept_id')->references('id')->on('concepts');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concepts_response_freight');
    }
};
