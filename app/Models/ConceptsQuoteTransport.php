<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptsQuoteTransport extends Model
{
    use HasFactory;
        protected $table = 'concepts_quote_transport';

    // Sólo necesitas estos dos
    protected $fillable = ['quote_transport_id', 'concepts_id'];

    public $timestamps = false; // si no tienes created_at/updated_at

    public function quoteTransport()
    {
        return $this->belongsTo(QuoteTransport::class, 'quote_transport_id');
    }

    public function concept()
    {
        return $this->belongsTo(Concepts::class, 'concepts_id');
    }
}

