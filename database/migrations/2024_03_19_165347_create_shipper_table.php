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
        Schema::create('shipper', function (Blueprint $table) {
            $table->id();
            $table->string('type_id');
            $table->string('number_id');
            $table->string('name_businessname');
            $table->string('addres');
            $table->string('contact_name');
            $table->string('contact_number');
            $table->string('contact_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipper');
    }
};
