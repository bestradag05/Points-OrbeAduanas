<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptsResponse extends Model
{
    use HasFactory;
    protected $table = 'concepts_response';

    // 1) Permitir asignación masiva de estos campos
    protected $fillable = [
        'concepts_id',
        'response_transport_quote_id',
        'concepts_id',
        'net_amount',
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
    public function concepts()
    {
        return $this->belongsTo(
            Concepts::class,      // o App\Models\Concepts si tu modelo se llama así
            'concepts_id'        // columna en tu tabla pivote
        );
    }
}