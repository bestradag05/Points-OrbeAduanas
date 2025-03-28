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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // nombre → name
            $table->foreignId('type_container_id')->constrained('type_containers'); // Relación
            $table->text('description')->nullable(); // descripcion → description
            $table->decimal('length', 8, 2);         // longitud → length
            $table->decimal('width', 8, 2);          // anchura → width
            $table->decimal('height', 8, 2);         // altura → height
            $table->decimal('volume', 8, 2)->nullable(); // volumen → volume (opcional)
            $table->decimal('max_load', 8, 2);       // carga_max → max_load
            $table->string('state')->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
