<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResponseTransportQuote extends Model
{
    protected $fillable = [
        'nro_response',
        'provider_id',
        'provider_cost',
        'commission',
        'total',
        'status',
        'nro_response'
    ];


    protected static function booted()
    {
        static::creating(function ($m) {
            $year = date('y');
            $prefix = 'RPTA-';
            $last = static::latest('id')->first();
            $nextSeq = $last ? $last->id + 1 : 1;
            $m->nro_response = "{$prefix}{$year}{$nextSeq}";
        });
    }
    public static function generateNroResponse(): string
    {
        $last  = static::latest('id')->first();
        $year  = date('y');
        $prefx = 'RPTA-';

        if (! $last || ! $last->nro_response) {
            return "{$prefx}{$year}1";
        }

        $seq = (int) substr($last->nro_response, strlen($prefx . $year)) + 1;
        return "{$prefx}{$year}{$seq}";
    }


    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'provider_id');
    }

    public function quoteTransports()
    {
        return $this->belongsToMany(
            QuoteTransport::class,
            'quote_transport_response',
            'response_quote_id',
            'quote_transport_id'
        );
    }
    // App\Models\ResponseTransportQuote.php

    public function conceptsTransportQuote()
    {
        return $this->hasMany(ConceptsTransportQuote::class, 'response_quote_id');
    }
}
