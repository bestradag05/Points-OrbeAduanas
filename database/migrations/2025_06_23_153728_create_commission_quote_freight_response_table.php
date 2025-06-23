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
        Schema::create('commission_quote_freight_response', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commission_id');
            $table->unsignedBigInteger('response_freight_quotes_id');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->foreign('response_freight_quotes_id', 'cqr_qfr_fk')->references('id')->on('response_freight_quotes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_quote_freight_response');
    }
};
