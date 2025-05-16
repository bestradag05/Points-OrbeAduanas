<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResponseTransportQuote extends Model
{
    protected $fillable = [
        'provider_id',
        'provider_cost',
        'commission',
        'total',
        'status'
    ];


    // Genera "RPTA-YY{n}"
    public static function generateNroResponse(): string
    {
    
        // Obtener el último registro
        $lastCode = self::latest('id')->first();
        $year = date('y');
        $prefix = 'RPTA-';

        if (!$lastCode || empty($lastCode->nro_response)) {
            return $prefix . $year . '1';
        } else {
            // Calculamos desde dónde extraer la parte numérica
            $offset = strlen($prefix . $year);
            $number = (int) substr($lastCode->nro_response, $offset);
            $number++;
            return $prefix . $year . $number;
        }
    }

    protected static function booted()
    {
        static::creating(function ($quote) {
            // Si no tiene un número de operación, generarlo
            if (empty($quote->nro_response)) {
                $quote->nro_response = $quote->generateNroResponse();
            }
        });
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
