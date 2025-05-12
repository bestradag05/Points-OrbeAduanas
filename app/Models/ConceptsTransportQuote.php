<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptsTransportQuote extends Model
{
    use HasFactory;

    protected $table = 'concepts_transport_quote';

    protected $fillable = [
        'quote_transport_id',
        'id_concepts',
        'response_quote_id',
        'value_concept',
        'added_value',
        'net_amount',
        'igv',
        'total',
        'additional_points',
    ];

    // Relación con QuoteTransport
    public function quoteTransport()
    {
        return $this->belongsTo(QuoteTransport::class, 'quote_transport_id');
    }

    // Relación con Concepts
    public function concept()
    {
        return $this->belongsTo(Concepts::class, 'id_concepts');
    }
    public function response()
    {
        return $this->belongsTo(ResponseTransportQuote::class, 'response_quote_id');
    }
    public function conceptsTransportQuote()
    {
        return $this->hasMany(ConceptsTransportQuote::class, 'response_quote_id');
    }
}
