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
            $table->decimal('value_utility', 8, 2)->nullable();
            $table->decimal('accepted_answer_value', 8, 2);
            $table->decimal('value_sale', 8, 2);
            $table->decimal('profit', 8, 2);
            $table->string('payment_state')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('weight')->nullable();
            $table->date('withdrawal_date')->nullable();
            $table->enum('state', ['Pendiente', 'Aceptado', 'Anulado', 'Rechazado'])->default('Pendiente');
            $table->string('nro_operation')->nullable();
            $table->string('nro_quote_commercial')->nullable();
            $table->unsignedBigInteger('id_supplier')->nullable();
            $table->unsignedBigInteger('quote_transport_id')->nullable();
            $table->timestamps();

            $table->foreign('id_supplier')->references('id')->on('suppliers');
            $table->foreign('quote_transport_id')->references('id')->on('quote_transport');
            $table->foreign('nro_operation')->references('nro_operation')->on('routing');
            $table->foreign('nro_quote_commercial')->references('nro_quote_commercial')->on('commercial_quote');
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
