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
        Schema::create('commission_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commercial_quote_id');  // Relación con Cotización Comercial
            $table->decimal('total_commission', 10, 2)->default(0);
            $table->decimal('total_profit', 10, 2)->default(0);   
            $table->integer('total_points')->default(0);           
            // Relaciones con Cotización Comercial o Operación
            $table->foreign('commercial_quote_id')->references('id')->on('commercial_quote')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_groups');
    }
};
