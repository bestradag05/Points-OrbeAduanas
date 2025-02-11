<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptTransport extends Model
{
    use HasFactory;

    protected $table = 'concepts_transport';

    protected $fillable =
    [
        'id_concepts',
        'id_transport',
        'value_concept',
        'added_value',
        'net_amount',
        'igv',
        'total',
        'additional_points'
    ];


    public function concepts()
    {
        return $this->belongsTo(Concepts::class, 'id_concepts');
    }

    // Relación con Freight
    public function transport()
    {
        return $this->belongsTo(Freight::class, 'id_transport');
    }

    public function additional_point()
    {
        return $this->morphOne(AdditionalPoints::class, 'additional', 'model_additional_concept_service', 'id_additional_concept_service');
    }
}
