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
        Schema::create('customs', function (Blueprint $table) {
            $table->id();
            $table->string('nro_orde')->unique();
            $table->string('ruc')->unique();
            $table->string('nro_dam')->unique();
            $table->date('date_register');
            $table->string('regime');
            $table->string('cif_value');
            $table->string('channel');
            $table->string('nro_bl');
            $table->string('regularization_date');
            $table->unsignedBigInteger('id_modality');
            $table->unsignedBigInteger('id_type_shipment');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_customer');
            $table->timestamps();

            $table->foreign('id_modality')->references('id')->on('modality');
            $table->foreign('id_type_shipment')->references('id')->on('type_shipment');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_customer')->references('id')->on('customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customs');
    }
};
