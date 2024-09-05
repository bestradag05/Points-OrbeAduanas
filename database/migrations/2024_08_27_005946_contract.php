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
        Schema::create('contract', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_personal');
            $table->string('contract_modality')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->decimal('salary', 8,2);
            $table->unsignedBigInteger('id_cargo');
            $table->unsignedBigInteger('id_company');
            $table->unsignedBigInteger('id_contract_modalities');
            $table->text('functions');
            $table->integer('user_register')->nullable();
            $table->integer('user_update')->nullable();
            $table->string('state')->nullable();
            $table->timestamps();

            $table->foreign('id_personal')->references('id')->on('personal');
            $table->foreign('id_cargo')->references('id')->on('cargo');
            $table->foreign('id_company')->references('id')->on('companys');
            $table->foreign('id_contract_modalities')->references('id')->on('contract_modalities');
            


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract');
    }
};
