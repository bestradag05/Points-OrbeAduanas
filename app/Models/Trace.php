<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Trace extends Model
{
    use HasFactory;

    protected $fillable = [
        'traceable_id',
        'traceable_type',
        'action',
        'justification',
        'user_id',
    ];


    public function traceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getReadableMessageAttribute()
    {
        $entity = match ($this->traceable_type) {
            QuoteTransport::class => 'cotización de transporte',
            QuoteFreight::class => 'cotización de flete',
            /* QuoteCustoms::class => 'cotización de aduana', */
            default => 'registro',
        };

        $action = match ($this->action) {
            'accepted' => 'Se aceptó',
            'rejected' => 'Se rechazó',
            'updated' => 'Se actualizó',
            'created' => 'Se creó',
            'deleted' => 'Se eliminó',
            default => 'Acción realizada sobre',
        };

        return "{$action} {$entity} N° {$this->traceable_id}";
    }
}
