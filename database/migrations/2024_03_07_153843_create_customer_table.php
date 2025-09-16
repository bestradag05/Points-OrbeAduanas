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
            $table->string('document_number')->unique()->nullable();
            $table->string('name_businessname')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_name');
            $table->string('contact_number')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('state');
            $table->unsignedBigInteger('id_document')->nullable();
            $table->unsignedBigInteger('id_personal');

            $table->enum('type', ['prospecto', 'cliente']);

            $table->timestamps();

            $table->foreign('id_document')->references('id')->on('customer_supplier_documents');
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
