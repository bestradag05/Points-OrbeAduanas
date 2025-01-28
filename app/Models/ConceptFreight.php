<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptFreight extends Model
{
    use HasFactory;

    protected $table = 'concepts_freight';

    protected $fillable =
    [
        'id_concepts',
        'id_freight',
        'value_concept',
        'value_concept_added',
        'total_value_concept',
        'additional_points'
    ];


    public function concepts()
    {
        return $this->belongsTo(Concepts::class, 'id_concepts');
    }

    // Relación con Freight
    public function freight()
    {
        return $this->belongsTo(Freight::class, 'id_freight');
    }

    public function additional_point()
    {
        return $this->morphOne(AdditionalPoints::class, 'additional', 'model_additional_concept_service', 'id_additional_concept_service');
    }
}
