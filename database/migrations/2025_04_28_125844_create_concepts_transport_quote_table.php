<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateConceptsTransportQuoteTable extends Migration {
    public function up() {
        Schema::create('concepts_transport_quote', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_transport_id')->constrained('quote_transport')->onDelete('cascade');
            $table->foreignId('id_concepts')->constrained('concepts')->onDelete('cascade');
            $table->foreignId('response_quote_id')->nullable()->constrained('response_transport_quotes')->onDelete('cascade');
            $table->decimal('value_concept', 8, 2)->nullable(); 
            $table->decimal('added_value', 8, 2)->nullable(); 
            $table->decimal('net_amount', 8, 2)->nullable(); 
            $table->decimal('igv', 8, 2)->nullable(); 
            $table->decimal('total', 8, 2)->nullable(); 
            $table->integer('additional_points')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('concepts_transport_quote');
    }
}