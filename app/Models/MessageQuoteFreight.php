<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageQuoteFreight extends Model
{
    use HasFactory;

    protected $table = 'message_quote_freight';

    protected $fillable = ['quote_freight_id', 'sender_id', 'message'];



    public function quoteFreight()
    {
        return $this->belongsTo(QuoteFreight::class, 'quote_freight_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

}
