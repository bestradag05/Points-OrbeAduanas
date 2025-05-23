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
            $table->unsignedBigInteger('concepts_id');
            $table->unsignedBigInteger('id_customs');
            $table->decimal('value_concept', 8 , 2);
            $table->decimal('added_value', 8, 2);
            $table->decimal('net_amount', 8, 2)->nullable();
            $table->decimal('igv', 8, 2)->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->integer('additional_points')->nullable();
            $table->timestamps();

            $table->foreign('concepts_id')->references('id')->on('concepts');
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
