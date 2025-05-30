<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResponseTransportQuote extends Model
{
    protected $fillable = [
        'quote_transport_id',
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

    // Inversa  N:1 → QuoteTransport
    public function quoteTransport()
    {
        return $this->belongsTo(QuoteTransport::class, 'quote_transport_id');
    }
    // 1:N → ConceptsResponse
    public function conceptResponses()
    {
        return $this->hasMany(ConceptsResponse::class, 'response_transport_quote_id','id');
    }
}
