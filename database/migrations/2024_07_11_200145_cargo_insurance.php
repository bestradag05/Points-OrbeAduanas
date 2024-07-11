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
        Schema::create('cargo_insurance', function (Blueprint $table) {
            $table->id();
            $table->string('certified_number')->nullable();
            $table->string('insured_references')->nullable();
            $table->date('date')->nullable();
            $table->decimal('sales_value', 8,2);
            $table->decimal('igv', 8, 2);
            $table->unsignedBigInteger('id_type_insurance')->nullable();
            $table->timestamps();

            $table->foreign('id_type_insurance')->references('id')->on('type_insurance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_insurance');
    }
};
