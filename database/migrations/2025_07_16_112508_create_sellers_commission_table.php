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
        Schema::create('sellers_commission', function (Blueprint $table) {
            $table->id();
            $table->morphs('commissionable'); // Crea commissionable_id y commissionable_type
            $table->unsignedBigInteger('personal_id'); // Relaciona la comisión con el vendedor
            $table->integer('points'); // Cantidad de puntos generados
            $table->decimal('amount', 10, 2); // Comisión generada
            $table->timestamps();

            $table->foreign('personal_id')->references('id')->on('personal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers_commission');
    }
};
