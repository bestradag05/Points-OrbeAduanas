<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moneys', function (Blueprint $table) {
            $table->id();
            $table->string('money');
            $table->string('description');
            $table->integer('user_register')->nullable();
            $table->integer('user_update')->nullable();
            $table->string('estate')->default('activo');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moneys');
    }
};
