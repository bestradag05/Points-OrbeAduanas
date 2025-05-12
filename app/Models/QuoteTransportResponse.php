<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteTransportResponse extends Model
{
    // Si tu tabla pivote se llama quote_transport_response:
    protected $table = 'quote_transport_response';

    // Campos asignables
    protected $fillable = [
        'quote_transport_id',
        'response_quote_id',
    ];

    // Relación a QuoteTransport
    public function quoteTransport()
    {
        return $this->belongsTo(QuoteTransport::class, 'quote_transport_id');
    }

    // Relación a ResponseTransportQuote
    public function response()
    {
        return $this->belongsTo(ResponseTransportQuote::class, 'response_quote_id');
    }
}
