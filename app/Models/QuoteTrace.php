<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteTrace extends Model
{
    protected $fillable = [
        'quote_id',
        'response_id',
        'service_type',
        'action',
        'justification',
        'user_id',
    ];

    public function quoteTransport()
    {
        return $this->belongsTo(QuoteTransport::class, 'quote_id');
    }

    public function response()
    {
        return $this->belongsTo(ResponseTransportQuote::class, 'response_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
