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
        Schema::create('shipment_state_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_state_id')->constrained('shipment_states')->onDelete('cascade');
            $table->string('document_name');
            $table->string('file_path');      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_state_documents');
    }
};
