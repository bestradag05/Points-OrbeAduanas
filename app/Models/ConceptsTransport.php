<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptsTransport extends Model
{
    use HasFactory;
    protected $table = 'concepts_transport';
    protected $fillable = [
        'transport_id',
        'concepts_id',
        'net_amount_response',
        'subtotal',
        'igv',
        'total',
        'additional_points'
    ];


    // Inversa N:1 → Transport
    public function transport()
    {
        return $this->belongsTo(Transport::class, 'id_transport');
    }
    // Inversa N:1 → Concept
    public function concepts()
    {
        return $this->belongsTo(Concept::class, 'concepts_id');
    }
    public function additional_point()
    {
        return $this->morphOne(AdditionalPoints::class, 'additional', 'model_additional_concept_service', 'id_additional_concept_service');
    }
}
