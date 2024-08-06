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
            $table->string('heLunes');
            $table->string('heMartes');
            $table->string('heMiercoles');
            $table->string('heJueves');
            $table->string('heViernes');
            $table->string('heSabado');
            $table->string('hsLunes');
            $table->string('hsMartes');
            $table->string('hsMiercoles');
            $table->string('hsJueves');
            $table->string('hsViernes');
            $table->string('hsSabado');
            $table->integer('tolerance');
            $table->date('dtFechaInicio');
            $table->date('dtFechaFin');
            $table->string('state');
            $table->integer('cod_user_create');
            $table->integer('cod_user_edit');
            $table->timestamps();
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
