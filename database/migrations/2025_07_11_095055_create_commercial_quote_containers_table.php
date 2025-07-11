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
        Schema::create('commercial_quote_containers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commercial_quote_id');
            $table->unsignedBigInteger('containers_id');
            $table->integer('container_quantity')->nullable();
            $table->string('commodity')->nullable();
            $table->string('nro_package')->nullable();
            $table->unsignedBigInteger('id_packaging_type')->nullable();
            $table->decimal('load_value', 8, 2)->nullable();
            $table->decimal('kilograms', 8, 2)->nullable();
            $table->decimal('volumen', 8, 2)->nullable();
            $table->text('measures')->nullable();
            $table->timestamps();

            $table->foreign('commercial_quote_id')->references('id')->on('commercial_quote');
            $table->foreign('containers_id')->references('id')->on('containers');
            $table->foreign('id_packaging_type')->references('id')->on('packing_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial_quote_containers');
    }
};
