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
        Schema::create('cargo', function(Blueprint $table){
            $table->id();
            $table->string('nombre')->nullable();
            $table->integer('CodUsuarioR')->nullable();
            $table->date('Registro')->nullable();
            $table->integer('CodUsuarioE')->nullable();
            $table->date('RegistroE')->nullable();
            $table->string('estado')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo');
    }
};
