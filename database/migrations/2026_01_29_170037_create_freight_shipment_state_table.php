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
        Schema::create('freight_shipment_state', function (Blueprint $table) {
            $table->id();
            $table->foreignId('freight_id')->constrained('freight')->onDelete('cascade');
            $table->foreignId('shipment_state_id')->constrained('shipment_states')->onDelete('cascade');
            $table->date('status_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freight_shipment_state');
    }
};
