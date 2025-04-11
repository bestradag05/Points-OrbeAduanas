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
        Schema::create('type_containers', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Previously 'nombre'
            $table->text('description')->nullable(); // Previously 'descripcion'
            $table->string('state')->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_containers');
    }
};
