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
        public function conceptsResponse()
    {
        return $this->hasMany(ConceptsResponse::class, 'concepts_id');
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

    // Relación many‐to‐many con QuoteTransport
    public function quoteTransports()
    {
        return $this->belongsToMany( QuoteTransport::class,'concepts_quote_transport','concepts_id','quote_transport_id');
    }

    // Ejemplo de scope para filtrar conceptos por tipo de servicio
    public function scopeByServiceType($query, $typeServiceId) {
    return $query->where('id_type_service', $typeServiceId);
    }

    public function scopeByShipmentType($query, $typeShipmentId) {
    return $query->where('id_type_shipment', $typeShipmentId);
    }
        // Relación many‐to‐many con ResponseTransportQuote
    public function responseTransportQuotes()
    {
        return $this->belongsToMany(ResponseTransportQuote::class,'concepts_response','transport_cost','concepts_id','response_transport_quote_id'
        )->withPivot('value_concept', 'net_amount');
    }
}
