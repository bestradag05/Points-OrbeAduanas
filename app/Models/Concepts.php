<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepts extends Model
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
        return $this->hasOne(ConceptFreight::class, 'id_concepts');
    }

    public function concept_transport()
    {
        return $this->hasOne(ConceptTransport::class, 'id_concepts');
    }

    public function custom()
    {
        return $this->belongsToMany(Custom::class);
    }

    public function freights()
    {
        return $this->belongsToMany(Freight::class, 'concepts_freight', 'id_concepts', 'id_freight')
                    ->withPivot(['value_concept', 'value_concept_added', 'total_value_concept', 'additional_points']);
    }

    public function transport()
    {
        return $this->belongsToMany(Transport::class);
    }
}
