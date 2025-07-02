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
        Schema::create('client_quote_traces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quote_transport')->onDelete('cascade');
            $table->enum('client_decision', ['Aceptado', 'Rechazado']);
            $table->text('justification')->nullable();
            $table->timestamp('decision_date')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_quote_traces');
    }
};
