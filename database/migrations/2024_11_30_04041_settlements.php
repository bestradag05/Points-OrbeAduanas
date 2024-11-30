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
        Schema::create('settlements', function(Blueprint $table){
            $table->id();
            $table->string('nro_order')->unique();
            $table->date('date');
            $table->string('customer');
            $table->string('gia_bl');
            $table->string('origin');
            $table->string('destination');
            $table->string('cif_value');
            $table->string('number_of_packages');
            $table->string('type_of_shipment');
            $table->string('regime');
            $table->string('dua_number');
            $table->string('channel');
            
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlements');
    }
};
