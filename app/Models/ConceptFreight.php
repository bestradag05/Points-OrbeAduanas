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
}
