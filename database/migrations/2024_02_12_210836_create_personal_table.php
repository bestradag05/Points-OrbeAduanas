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
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique();
            $table->string('names');
            $table->string('last_name');
            $table->string('mother_last_name');
            $table->date('birthdate')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('sexo')->nullable();
            $table->string('cellphone');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('img_url')->nullable();
            $table->string('state')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_document')->nullable();//TODO: Recordar cambiar el nullbale, no debe ser un valor null
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
        Schema::dropIfExists('personal');
    }
};
