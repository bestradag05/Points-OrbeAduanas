<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageQuoteTransport extends Model
{
    use HasFactory;

    protected $table = 'message_quote_transport';

    protected $fillable = ['quote_transport_id', 'sender_id', 'message'];



    public function quoteTransport()
    {
        return $this->belongsTo(QuoteTransport::class, 'quote_transport_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
}
