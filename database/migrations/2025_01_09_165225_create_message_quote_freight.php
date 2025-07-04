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
        Schema::create('message_quote_freight', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_freight_id');
            $table->unsignedBigInteger('sender_id');
            $table->mediumText('message');
            $table->timestamps();
            $table->foreign('quote_freight_id')->references('id')->on('quote_freight');
            $table->foreign('sender_id')->references('id')->on('users');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_quote_freight');
    }
};
