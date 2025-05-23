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
        Schema::create('concepts_quote_transport', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_transport_id')->constrained('quote_transport');
            $table->foreignId('concepts_id')->constrained('concepts');
        });
        
    }

  
    public function down(): void
    {
        Schema::dropIfExists('concepts_quote_transport');
        Schema::dropIfExists('quote_transport');
    }
};
