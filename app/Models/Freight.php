<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freight extends Model
{
    use HasFactory;


    protected $table = 'freight';

    protected $fillable = 
    [
        'roi', 
        'hawb_hbl', 
        'bl_work', 
        'date_register', 
        'edt', 
        'eta',
        'value_utility', 
        'value_freight', 
        'state',
        'id_quote_freight', 
        'nro_operation'
    ];

    public function concepts()
    {
        return $this->belongsToMany(Concepts::class, 'concepts_freight', 'id_freight', 'id_concepts')
                    ->withPivot(['value_concept', 'value_concept_added', 'total_value_concept', 'additional_points']);
    }


    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }

    public function insurance()
    {
        return $this->morphOne(Insurance::class, 'insurable', 'model_insurable_service', 'id_insurable_service');
    }

    public function additional_point()
    {
        return $this->morphMany(AdditionalPoints::class, 'additional', 'model_additional_service', 'id_additional_service');
    }
    
    public function quoteFreights()
    {
        return $this->hasMany(QuoteFreight::class, 'id', 'id_quote_freight');
    }
}
