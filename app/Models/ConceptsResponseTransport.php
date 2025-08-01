<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concept;

class ConceptsResponseTransport extends Model
{
    use HasFactory;
    protected $table = 'concepts_response_transport';

    // 1) Permitir asignación masiva de estos campos
    protected $fillable = [
        'response_transport_quote_id',
        'concepts_id',
        'net_amount',
        'igv',
        'total_sol',
        'total_usd',       // Total convertido a USD (con IGV)
        'value_utility',   // Utilidad en USD
        'sale_price',      // Costo de venta en USD
    ];

    // 2) Relación N:1 → ResponseTransportQuote
    public function response()
    {
        return $this->belongsTo(
            ResponseTransportQuote::class,
            'response_transport_quote_id'
        );
    }

    // 3) Relación N:1 → Concepts
    public function concept()
    {
        return $this->belongsTo(
            Concept::class,      // o App\Models\Concepts si tu modelo se llama así
            'concepts_id'        // columna en tu tabla pivote
        );
    }
}