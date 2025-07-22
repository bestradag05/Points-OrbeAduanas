<?php

namespace App\Traits;

use App\Models\QuoteJustifications;

trait HasJustifications
{


    public function registerJustification($model, $action, $justification)
    {
        QuoteJustifications::create([
            'quotable_type' => get_class($model), // El tipo de entidad relacionada (polimórfico)
            'quotable_id' => $model->id,          // El ID de la entidad relacionada
            'action' => $action,                     // La acción realizada
            'justification' => $justification,       // La justificación proporcionada
        ]);
    }
}
