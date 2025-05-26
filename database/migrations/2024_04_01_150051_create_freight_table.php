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
            $table->string('wr_loading')->nullable();
            $table->string('roi')->nullable()->unique();
            $table->string('hawb_hbl')->nullable();
            $table->string('bl_work')->nullable();
            $table->date('date_register')->nullable();
            $table->date('edt')->nullable();
            $table->date('eta')->nullable();
            $table->string('value_utility')->nullable();
            $table->decimal('value_freight', 8, 2)->nullable();
            $table->enum('state', ['Pendiente', 'En Proceso', 'Notificado', 'Cerrado'])->default('Pendiente');
            /* $table->unsignedBigInteger('id_insurance')->nullable(); */
            $table->string('nro_operation')->nullable();
            $table->string('nro_quote_commercial')->nullable();
            $table->unsignedBigInteger('id_quote_freight')->nullable();
            $table->timestamps();

            $table->foreign('nro_operation')->references('nro_operation')->on('routing');
            $table->foreign('nro_quote_commercial')->references('nro_quote_commercial')->on('commercial_quote');
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
