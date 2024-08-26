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
        Schema::create('timeSchedule', function (Blueprint $table) {
            $table->id();
            $table->string('heLunes')->nullable();
            $table->string('heMartes')->nullable();
            $table->string('heMiercoles')->nullable();
            $table->string('heJueves')->nullable();
            $table->string('heViernes')->nullable();
            $table->string('heSabado')->nullable();
            $table->string('hsLunes')->nullable();
            $table->string('hsMartes')->nullable();
            $table->string('hsMiercoles')->nullable();
            $table->string('hsJueves')->nullable();
            $table->string('hsViernes')->nullable();
            $table->string('hsSabado')->nullable();
            $table->integer('tolerance')->nullable();
            $table->date('dtFechaInicio')->nullable();
            $table->date('dtFechaFin')->nullable();
            $table->string('state')->nullable();
            $table->unsignedBigInteger('id_personal')->nullable();
            $table->integer('cod_user_create')->nullable();
            $table->integer('cod_user_edit')->nullable();
            $table->timestamps();

            $table->foreign('id_personal')->references('id')->on('personal');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeSchedule');
    }
};
