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
        Schema::create('insurance', function (Blueprint $table) {
            $table->id();
            $table->string('certified_number')->nullable();
            $table->string('insured_references')->nullable();
            $table->date('date')->nullable();
            $table->decimal('insurance_value', 8,2);
            $table->decimal('insurance_value_added', 8,2);
            $table->decimal('insurance_sale', 8,2);
            $table->decimal('sales_value', 8,2);
            $table->decimal('sales_price', 8, 2);
            $table->integer('additional_points')->nullable();
            $table->unsignedBigInteger('id_type_insurance')->nullable();
            $table->unsignedBigInteger('id_insurable_service');
            $table->string('model_insurable_service');
            $table->string('name_service');
            $table->string('state');
            $table->timestamps();

            $table->foreign('id_type_insurance')->references('id')->on('type_insurance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance');
    }
};
