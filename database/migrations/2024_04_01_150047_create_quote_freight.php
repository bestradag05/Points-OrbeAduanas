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
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('unit_of_weight')->nullable();
            $table->decimal('volumen_kgv', 8, 2)->nullable();
            $table->string('unit_of_volumen_kgv')->nullable();
            $table->string('packages')->nullable();
            $table->text('measures')->nullable();
            $table->decimal('ocean_freight', 8, 2)->nullable();
            $table->decimal('utility', 8, 2)->nullable();
            $table->decimal('operations_commission', 8, 2)->nullable();
            $table->decimal('pricing_commission', 8, 2)->nullable();
            $table->decimal('total_ocean_freight', 8, 2)->nullable();
            $table->string('nro_operation')->nullable();
            $table->string('nro_quote_commercial');
            $table->enum('state', ['Pendiente', 'Enviado', 'Cerrado', 'Anulado', 'Rechazado'])->default('Pendiente');
            $table->timestamps();


            $table->foreign('nro_operation')->references('nro_operation')->on('routing');
            $table->foreign('nro_quote_commercial')->references('nro_quote_commercial')->on('commercial_quote');
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
