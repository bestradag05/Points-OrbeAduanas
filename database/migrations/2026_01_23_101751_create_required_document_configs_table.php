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
        Schema::create('required_document_configs', function (Blueprint $table) {
            $table->id();
            $table->string('service_type')->index(); // 'freight', 'customs', 'transport', 'insurance'
            $table->string('document_name'); // 'Routing Order', 'Factura Comercial', etc
            $table->boolean('is_required')->default(true); // Es obligatorio
            $table->boolean('is_auto_generated')->default(false); // Se genera automáticamente (ej: RO)
            $table->integer('order')->default(0); // Orden de visualización
            $table->text('description')->nullable(); // Descripción/notas
            $table->timestamps();

            // Índice único para evitar duplicados
            $table->unique(['service_type', 'document_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('required_document_configs');
    }
};
