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
            $table->string('roi')->nullable();
            $table->string('hawb_hbl')->nullable();
            $table->string('bl_work')->nullable();
            $table->date('date_register')->nullable();
            $table->date('edt')->nullable();
            $table->date('eta')->nullable();
            $table->string('value_utility')->nullable();
            $table->string('value_freight')->nullable();
            $table->string('state');
            /* $table->unsignedBigInteger('id_insurance')->nullable(); */
            $table->string('nro_operation')->nullable();
            $table->unsignedBigInteger('id_quote_freight')->nullable();
            $table->timestamps();

            $table->foreign('nro_operation')->references('nro_operation')->on('routing');
            $table->foreign('id_quote_freight')->references('id')->on('quote_freight');
            /* $table->foreign('id_insurance')->references('id')->on('insurance'); */
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
