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
        Schema::create('transport', function (Blueprint $table) {
            $table->id();
            $table->string('nro_operation_transport')->unique();
            $table->date('date_register')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('nro_orden')->nullable();
            $table->string('nro_dua')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->decimal('transport_value', 8, 2)->nullable();
            $table->decimal('added_value', 8, 2)->nullable();
            $table->decimal('tax_base', 8, 2)->nullable();
            $table->decimal('igv', 8, 2)->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->string('additional_points')->nullable();
            $table->string('payment_state')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('weight')->nullable();
            $table->date('withdrawal_date')->nullable();
            $table->string('state')->nullable();
            $table->string('nro_operation');
            $table->unsignedBigInteger('id_supplier')->nullable();
            $table->unsignedBigInteger('id_quote_transport')->nullable();
            $table->timestamps();

            $table->foreign('id_supplier')->references('id')->on('suppliers');
            $table->foreign('id_quote_transport')->references('id')->on('quote_transport');
            $table->foreign('nro_operation')->references('nro_operation')->on('routing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport');
    }
};
