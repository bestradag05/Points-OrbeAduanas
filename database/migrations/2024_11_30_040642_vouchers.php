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
        Schema::create('vouchers', function(Blueprint $table){
            $table->id();
            $table->string('ruc');
            $table->string('name_businessname');
            $table->string('serial_number');
            $table->decimal('total_amount', 8,2);
            $table->string('type_of_receipt');
            $table->string('document_url');
            $table->unsignedBigInteger('id_settlement');
            $table->timestamps();

            $table->foreign('id_settlement')->references('id')->on('settlements');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
