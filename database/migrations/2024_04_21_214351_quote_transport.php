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
            $table->dateTime('shipping_date');
            $table->dateTime('response_date')->nullable();
            $table->unsignedBigInteger('id_customer');
            $table->string('pick_up')->nullable();
            $table->string('delivery')->nullable();
            $table->string('container_return')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('max_attention_hour')->nullable();
            $table->string('gang')->nullable();
            $table->decimal('cost_gang', 8 , 2)->nullable();
            $table->decimal('old_cost_gang', 8 , 2)->nullable();
            $table->string('guard')->nullable();
            $table->decimal('cost_guard', 8, 2)->nullable();
            $table->decimal('old_cost_guard', 8, 2)->nullable();
            $table->text('customer_detail')->nullable();
            $table->string('commodity')->nullable();
            $table->string('packaging_type')->nullable();
            $table->string('load_type')->nullable();
            $table->string('container_type')->nullable();
            $table->string('ton_kilogram')->nullable();
            $table->string('stackable')->nullable();
            $table->string('cubage_kgv')->nullable();
            $table->string('total_weight')->nullable();
            $table->string('packages')->nullable();
            $table->text('cargo_detail')->nullable();
            $table->string('measures')->nullable();
            $table->string('nro_operation')->nullable();
            $table->string('lcl_fcl');
            $table->unsignedBigInteger('id_type_shipment');
            $table->text('readjustment_reason')->nullable();
            $table->text('observations')->nullable();
            $table->decimal('old_cost_transport', 8, 2)->nullable();
            $table->decimal('cost_transport', 8, 2)->nullable();
            $table->date('withdrawal_date')->nullable();
            $table->enum('state', ['Pendiente', 'Respondido', 'Aceptada', 'Reajuste', 'Observado', 'Rechazada'])->default('pendiente');
            $table->timestamps();


            $table->foreign('nro_operation')->references('nro_operation')->on('routing');
            $table->foreign('id_customer')->references('id')->on('customer');
            $table->foreign('id_type_shipment')->references('id')->on('type_shipment');

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
