<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ClientQuoteTrace extends Model
{
    protected $fillable = [
        'quote_id',
        'client_decision',
        'justification',
        'decision_date',
        'user_id'
    ];

    public function quote(): BelongsTo
    {
        return $this->belongsTo(QuoteTransport::class, 'quote_id');
    }

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
