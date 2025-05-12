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
            $table->enum('area_type', ['comercial', 'transporte'])
                  ->default('comercial')
                  ->comment('Indica si el proveedor es para área Comercial o Transporte');
            $table->string('address');
            $table->string('contact_name');
            $table->string('contact_number');
            $table->string('contact_email');
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
