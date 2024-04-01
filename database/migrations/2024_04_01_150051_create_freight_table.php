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
        Schema::create('freight', function (Blueprint $table) {
            $table->id();
            $table->string('roi');
            $table->string('hawb_hbl');
            $table->string('bl_work');
            $table->date('edt');
            $table->date('eta');
            $table->string('value_utility');
            $table->string('value_freight');
            $table->string('nro_operation');
            $table->timestamps();

            $table->foreign('nro_operation')->references('nro_operation')->on('routing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freight');
    }
};
