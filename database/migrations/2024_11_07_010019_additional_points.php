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
        Schema::create('additional_points', function (Blueprint $table) {
            $table->id();
            $table->date('date_register')->nullable();
            $table->string('bl_to_work')->nullable();
            $table->string('ruc_to_invoice')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('type_of_service')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->decimal('igv', 8, 2)->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->string('points')->nullable();
            $table->unsignedBigInteger('id_additional_service');
            $table->string('model_additional_service');
            $table->string('additional_type');
            $table->string('state')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_points');
    }
};
