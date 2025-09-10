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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            /* $table->string('document_number')->unique(); */
            $table->string('name_businessname');
            $table->enum('area_type', ['comercial', 'transporte', 'pricing'])->default('comercial');
            $table->enum('provider_type', ['TRANSPORTISTA', 'AGENTE DE CARGA', 'COMERCIAL'])->nullable();
            $table->string('document_number')->nullable();
            $table->string('document_type')->nullable();
            $table->string('address');
            $table->string('contact_name')->nullable();
            $table->string('contact_number');
            $table->string('contact_email')->nullable();
            // Transporte
            $table->string('cargo_type')->nullable();       // Ej. Contenedores, suelta, peligrosa
            $table->string('unit')->nullable();             // Ej. Camión, Van, etc.
            // Agente de Carga
            $table->string('country')->nullable();          // País de operación
            $table->string('city')->nullable();             // Ciudad base
            $table->string('state');
            /* $table->unsignedBigInteger('id_document')->nullable(); */
            $table->timestamps();
            /* $table->foreign('id_document')->references('id')->on('customer_supplier_documents'); */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
