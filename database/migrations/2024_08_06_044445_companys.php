<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companys', function (Blueprint $table) {
            $table->id();
            $table->string('ruc');
            $table->string('business_name');
            $table->string('address');
            $table->string('manager');
            $table->string('phone');
            $table->string('email');
            $table->integer('user_register')->nullable();
            $table->integer('user_update')->nullable();
            $table->string('avatar');
            $table->string('estate')->default('activo');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companys');
    }
};
