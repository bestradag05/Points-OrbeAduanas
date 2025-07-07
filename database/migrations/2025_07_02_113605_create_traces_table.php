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
        Schema::create('traces', function (Blueprint $table) {
           $table->id();
            // Polimorfismo: traceable_id y traceable_type
            $table->morphs('traceable');
            // Acción (accepted, rejected, updated, etc.)
            $table->string('action');
            // Texto descriptivo o justificación opcional
            $table->text('justification')->nullable();
            // Usuario responsable
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traces');
    }
};
