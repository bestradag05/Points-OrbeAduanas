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
        Schema::create('quote_freight', function (Blueprint $table) {
            $table->id();
            $table->string('nro_quote')->unique();
            $table->dateTime('shipping_date')->nullable();
            $table->dateTime('response_date')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->string('commodity')->nullable();
            $table->string('packaging_type')->nullable();
            $table->string('load_type')->nullable();
            $table->string('container_type')->nullable();
            $table->string('ton_kilogram')->nullable();
            $table->string('cubage_kgv')->nullable();
            $table->string('total_weight')->nullable();
            $table->string('packages')->nullable();
            $table->string('measures')->nullable();
            $table->decimal('ocean_freight', 8, 2)->nullable();
            $table->string('nro_operation');
            $table->enum('state', ['Borrador','Pendiente', 'Respondido', 'Aceptada', 'Reajuste', 'Observado', 'Rechazada'])->default('Borrador');
            $table->timestamps();


            $table->foreign('nro_operation')->references('nro_operation')->on('routing');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_freight');
    }
};
