<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptsResponseFreight extends Model
{
    use HasFactory;

    protected $table = 'concepts_response_freight';

    // 1) Permitir asignación masiva de estos campos
    protected $fillable = [
        'response_freight_id',
        'concept_id',
        'unit_cost',
        'fixed_miltiplyable_cost',
        'observations',
        'final_cost',
        'net_cost'
    ];
}
