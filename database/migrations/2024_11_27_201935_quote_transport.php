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
        Schema::create('quote_transport', function (Blueprint $table) {
            $table->id();
            $table->date('shipping_date');
            $table->date('response_date');
            $table->string('pick_up')->nullable();
            $table->string('delivery')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('max_attention_hour')->nullable();
            $table->string('gang')->nullable();
            $table->string('packaging_type')->nullable();
            $table->string('stackable')->nullable();
            $table->string('nro_operation');
            $table->string('comment')->nullable();
            $table->enum('state', ['Pendiente', 'Aceptada', 'Rechazada'])->default('pendiente');
            $table->timestamps();


            $table->foreign('nro_operation')->references('nro_operation')->on('routing');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_transport');
    }
};
