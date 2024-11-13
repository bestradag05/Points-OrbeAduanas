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
            $table->string('ruc')->unique();
            $table->string('name_businessname')->unique();
            $table->string('contact_name');
            $table->string('contact_number');
            $table->string('contact_email');
            $table->string('state')->nullable();
            $table->unsignedBigInteger('id_personal');
            $table->timestamps();

            $table->foreign('id_personal')->references('id')->on('personal');
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
