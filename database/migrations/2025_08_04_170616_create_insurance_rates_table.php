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
        Schema::create('insurance_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_type_id')->constrained('type_insurance')->onDelete('cascade');
            $table->string('shipment_type_description');
            $table->decimal('min_value', 10, 2);
            $table->decimal('fixed_cost', 10, 2);
            $table->decimal('percentage', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_rates');
    }
};
