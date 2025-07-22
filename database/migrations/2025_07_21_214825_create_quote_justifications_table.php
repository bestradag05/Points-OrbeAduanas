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
        Schema::create('quote_justifications', function (Blueprint $table) {
            $table->id();
            $table->morphs('quotable');  // Polymorphic relation (quotable_type y quotable_id)
            $table->string('action');  // Action taken on the quote
            $table->text('justification');  // Justification provided by the client
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_justifications');
    }
};
