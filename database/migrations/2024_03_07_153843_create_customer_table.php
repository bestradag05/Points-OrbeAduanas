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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique();
            $table->string('name_businessname')->unique();
            $table->string('address');
            $table->string('contact_name');
            $table->string('contact_number');
            $table->string('contact_email');
            $table->string('state');
            $table->unsignedBigInteger('id_document');//TODO: Recordar cambiar el nullbale, no debe ser un valor null
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_document')->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
