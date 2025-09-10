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
        'concepts_id',
        'id_freight',
        'value_concept',
        'has_igv'
    ];


    public function concept()
    {
        return $this->belongsTo(Concept::class, 'concepts_id');
    }

    // Relación con Freight
    public function freight()
    {
        return $this->belongsTo(Freight::class, 'id_freight');
    }


}
