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
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('cellphone');
            $table->string('email')->nullable();
            $table->string('dni')->nullable()->unique();
            $table->string('immigration_card')->nullable()->unique();
            $table->string('passport')->nullable()->unique();
            $table->string('img_url')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal');
    }
};
