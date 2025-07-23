<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;

    protected $table = 'points';

    protected $fillable = [
        'pointable_id',   // ID de la entidad asociada (Flete, Aduana, etc.)
        'pointable_type', // Tipo de entidad asociada (Flete, Aduana, etc.)
        'personal_id',
        'point_type',     // El tipo de punto (puro o adicional)
        'quantity'        // La cantidad de puntos generados
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    public function pointable()
    {
        return $this->morphTo();  // Define la relación polimórfica
    }
}
