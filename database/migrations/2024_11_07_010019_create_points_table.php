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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->morphs('pointable'); // Creates pointable_id and pointable_type
            $table->unsignedBigInteger('personal_id');// Creates pointable_id and pointable_type
            $table->enum('point_type', ['puro', 'adicional']); // For distinguishing pure vs additional points
            $table->integer('quantity')->default(1); // Amount of points (default is 1)
            $table->timestamps(); // Timestamps for created_at and updated_at

            $table->foreign('personal_id')->references('id')->on('personal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
