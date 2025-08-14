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
        Schema::create('sellers_commission', function (Blueprint $table) {
            $table->id();
            $table->morphs('commissionable');
            $table->unsignedBigInteger('commission_group_id');  
            $table->unsignedBigInteger('personal_id'); 
            $table->decimal('cost_of_sale', 10, 2); 
            $table->decimal('net_cost', 10, 2); 
            $table->decimal('utility', 10, 2); 
            $table->boolean('insurance')->default(false); 
            $table->decimal('gross_profit', 10, 2); 
            $table->integer('pure_points'); 
            $table->integer('additional_points')->nullable(); 
            $table->decimal('distributed_profit', 10, 2)->nullable(); 
            $table->decimal('remaining_balance', 10, 2)->nullable(); 
            $table->decimal('generated_commission', 10, 2)->nullable(); 
            $table->timestamps();

            $table->foreign('commission_group_id')->references('id')->on('commission_groups')->onDelete('cascade');
            $table->foreign('personal_id')->references('id')->on('personal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers_commission');
    }
};
