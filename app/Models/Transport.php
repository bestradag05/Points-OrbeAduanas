<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $table = 'transport';

    protected $fillable = [
        'nro_operation_transport', 
        'nro_orden', 
        'date_register', 
        'invoice_number', 
        'nro_dua', 
        'origin', 
        'destination', 
        'total_transport', 
        'payment_state', 
        'payment_date',  
        'weight', 
        'withdrawal_date', 
        'state', 
        'nro_operation', 
        'nro_quote_commercial', 
        'id_supplier', 
        'id_quote_transport'
    ];


    protected $casts = [
        'total_transport' => 'float',
    ];


    // Evento que se ejecuta antes de guardar el modelo
    protected static function booted()
    {
        static::creating(function ($transport) {
            // Si no tiene un número de operación, generarlo
            if (empty($transport->nro_operation_transport)) {
                $transport->nro_operation_transport = $transport->generateNroOperation();
            }
        });
    }

    // Método para generar el número de operación
    public function generateNroOperation()
    {
        // Obtener el último registro
        $lastCode = self::latest('id')->first();
        $year = date('y');
        $prefix = 'TRAN-';

        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            return $prefix . $year . '1';
        } else {
            // Extraer el número y aumentarlo
            $number = (int) substr($lastCode->nro_operation_transport, 7);
            $number++;
            return $prefix . $year . $number;
        }
    }


    /* Relaciones */

    public function concepts()
    {
        return $this->belongsToMany(Concepts::class, 'concepts_transport', 'id_transport', 'id_concepts')
            ->withPivot(['value_concept', 'added_value', 'net_amount', 'igv', 'total']);
    }

    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }

    public function commercial_quote()
    {
        return $this->belongsTo(CommercialQuote::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }

    public function additional_point()
    {
        return $this->morphMany(AdditionalPoints::class, 'additional', 'model_additional_service', 'id_additional_service');
    }


    public function quoteTransports()
    {
        return $this->hasMany(QuoteTransport::class, 'id', 'id_quote_transport');
    }
}
