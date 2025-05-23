<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptCustoms extends Model
{
    use HasFactory;


    protected $table = 'concepts_customs';

    protected $fillable =
    [
        'concepts_id',
        'id_customs',
        'value_concept',
        'added_value',
        'net_amount',
        'igv',
        'total',
        'additional_points'
    ];


    public function concepts()
    {
        return $this->belongsTo(Concepts::class, 'concepts_id');
    }

    // Relación con customs
    public function customs()
    {
        return $this->belongsTo(Custom::class, 'id_customs');
    }

    public function additional_point()
    {
        return $this->morphOne(AdditionalPoints::class, 'additional', 'model_additional_concept_service', 'id_additional_concept_service');
    }

}
