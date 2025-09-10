<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    use HasFactory;

    protected $table = 'concepts';

    protected $fillable = ['name', 'id_type_shipment', 'id_type_service'];

    public function typeService()
    {
        return $this->belongsTo(TypeService::class, 'id_type_service', 'id');
    }

    public function typeShipment()
    {
        return $this->belongsTo(TypeShipment::class, 'id_type_shipment', 'id');
    }

    public function concept_freight()
    {
        return $this->hasOne(ConceptFreight::class, 'concepts_id');
    }

    // 1:N directo si usas modelos pivote
    public function conceptsTransport()
    {
        return $this->hasMany(ConceptsTransport::class, 'concepts_id');
    }
    public function conceptsResponseTransport()
    {
        return $this->hasMany(ConceptsResponseTransport::class, 'concepts_id');
    }
    public function custom()
    {
        return $this->belongsToMany(Custom::class);
    }

    public function freights()
    {
        return $this->belongsToMany(Freight::class, 'concepts_freight', 'concepts_id', 'id_freight')
            ->withPivot(['value_concept', 'value_concept_added', 'total_value_concept', 'additional_points']);
    }

    public function responseQuoteFreights()
    {
        return $this->belongsToMany(ResponseFreightQuotes::class, 'concepts_response_freight', 'concept_id', 'response_freight_id')
            ->withPivot(['unit_cost', 'fixed_miltiplyable_cost', 'observations', 'final_cost', 'has_igv']);
    }

    // Relación many‐to‐many con QuoteTransport
    public function quoteTransport()
    {
        return $this->belongsToMany(QuoteTransport::class, 'concepts_quote_transport', 'concepts_id', 'quote_transport_id');
    }

    // Ejemplo de scope para filtrar conceptos por tipo de servicio
    public function scopeByServiceType($query, $typeServiceId)
    {
        return $query->where('id_type_service', $typeServiceId);
    }

    public function scopeByShipmentType($query, $typeShipmentId)
    {
        return $query->where('id_type_shipment', $typeShipmentId);
    }
    // Relación many‐to‐many con ResponseTransportQuote
    public function responseTransportQuotes()
    {
        return $this->belongsToMany(
            ResponseTransportQuote::class,
            'concepts_response_transport',
            'concepts_id',
            'response_transport_quote_id'
        )->withPivot('net_amount');
    }
    public function transport()
    {
        return $this->belongsToMany(
            Transport::class,
            'concepts_transport',
            'concepts_id',
            'transport_id'
        )->withPivot('added_value', 'igv', 'total');
    }


    /* Relacion con cotizacion enviada al cliente */

    public function quoteSentClient()
    {
        return $this->belongsToMany(QuotesSentClient::class, 'quote_sent_client_concepts', 'quote_sent_client_id', 'concept_id')
            ->withPivot(['value_concept']);
    }


}
