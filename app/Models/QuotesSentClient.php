<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotesSentClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nro_quote_commercial',
        'commercial_quote_id',
        'status'
    ];


    public function commercialQuote()
    {
        return $this->belongsTo(CommercialQuote::class, 'commercial_quote_id');
    }
}
