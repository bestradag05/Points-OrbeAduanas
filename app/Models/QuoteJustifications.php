<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteJustifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotable_type',  // Relación polimórfica: tipo de modelo relacionado
        'quotable_id',    // Relación polimórfica: ID del modelo relacionado
        'action',          // Acción tomada sobre la cotización
        'justification',   // Justificación proporcionada por el cliente
    ];


    public function quotable()
    {
        return $this->morphTo();  // Polymorphic relation
    }
}
