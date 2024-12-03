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
            $table->date('shipping_date');
            $table->date('response_date')->nullable();
            $table->string('pick_up')->nullable();
            $table->string('delivery')->nullable();
            $table->string('container_return')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('max_attention_hour')->nullable();
            $table->string('gang')->nullable();
            $table->string('guard')->nullable();
            $table->string('customer_detail')->nullable();
            $table->string('commodity')->nullable();
            $table->string('packaging_type')->nullable();
            $table->string('load_type')->nullable();
            $table->string('container_type')->nullable();
            $table->string('ton_kilogram')->nullable();
            $table->string('stackable')->nullable();
            $table->string('cubage_kgv')->nullable();
            $table->string('total_weight')->nullable();
            $table->string('packages')->nullable();
            $table->string('cargo_detail')->nullable();
            $table->string('measures')->nullable();
            $table->string('nro_operation');
            $table->string('lcl_fcl');
            $table->enum('state', ['Pendiente', 'Aceptada', 'Rechazada'])->default('pendiente');
            $table->timestamps();


            $table->foreign('nro_operation')->references('nro_operation')->on('routing');

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
