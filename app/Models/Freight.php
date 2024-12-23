<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freight extends Model
{
    use HasFactory;


    protected $table = 'freight';

    protected $fillable = ['roi', 'hawb_hbl', 'bl_work', 'date_register', 'edt', 'eta','value_utility', 'value_freight', 'state', 'nro_operation'];

    public function concepts()
    {
        return $this->belongsToMany(Concepts::class, 'concepts_freight', 'id_freight', 'id_concepts')->withPivot('value_concept');;
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
    
}
