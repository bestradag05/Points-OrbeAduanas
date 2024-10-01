<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freight extends Model
{
    use HasFactory;


    protected $table = 'freight';

    protected $fillable = ['roi', 'hawb_hbl', 'bl_work', 'edt', 'eta','value_utility', 'value_freight', 'state', 'id_cargo_insurance', 'nro_operation'];

    public function concepts()
    {
        return $this->belongsToMany(Concepts::class, 'concepts_freight', 'id_freight', 'id_concepts')->withPivot('value_concept');;
    }

    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }
    
}
