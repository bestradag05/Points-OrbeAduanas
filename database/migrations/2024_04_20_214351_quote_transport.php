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
        Schema::create('quote_transport', function (Blueprint $table) {
            $table->id();
            $table->string('nro_quote')->unique();
            $table->string('pick_up')->nullable();
            $table->unsignedBigInteger('pickup_warehouse')->nullable();
            $table->string('delivery')->nullable();
            $table->unsignedBigInteger('delivery_warehouse')->nullable();
            $table->string('container_return')->nullable();
            $table->string('gang')->nullable();
            $table->decimal('cost_gang', 8, 2)->nullable();
            $table->string('guard')->nullable();
            $table->decimal('cost_guard', 8, 2)->nullable();
            $table->string('commodity')->nullable();
            $table->string('packaging_type')->nullable();
            $table->string('load_type')->nullable();
            $table->string('container_type')->nullable();
            $table->string('ton_kilogram')->nullable();
            $table->string('stackable')->nullable();
            $table->string('cubage_kgv')->nullable();
            $table->string('total_weight')->nullable();
            $table->string('packages')->nullable();
            $table->string('measures')->nullable();
            $table->string('lcl_fcl')->nullable();
            $table->unsignedBigInteger('id_type_shipment')->nullable();
            $table->text('observations')->nullable();
            $table->date('withdrawal_date')->nullable();
            $table->string('nro_operation')->nullable();
            $table->string('nro_quote_commercial');
            $table->enum('state', ['Pendiente', 'Aceptado', 'Enviado', 'Anulado', 'Cerrado', 'Rechazado'])->default('Pendiente');
            $table->timestamps();

            $table->foreign('nro_operation')->references('nro_operation')->on('routing');
            $table->foreign('id_type_shipment')->references('id')->on('type_shipment');
            $table->foreign('nro_quote_commercial')->references('nro_quote_commercial')->on('commercial_quote');
            $table->foreign('pickup_warehouse')->references('id')->on('warehouses');
            $table->foreign('delivery_warehouse')->references('id')->on('warehouses');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_transport');
    }
};
