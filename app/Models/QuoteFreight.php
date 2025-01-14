<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteFreight extends Model
{
    use HasFactory;

    protected $table = 'quote_freight';


    // Evento que se ejecuta antes de guardar el modelo
    protected static function booted()
    {
        static::creating(function ($quote) {
            // Si no tiene un número de operación, generarlo
            if (empty($quote->nro_quote)) {
                $quote->nro_quote = $quote->generateNroOperation();
            }
        });
    }

    // Método para generar el número de operación
    public function generateNroOperation()
    {
        // Obtener el último registro
        $lastCode = self::latest('id')->first();
        $year = date('y');
        $prefix = 'COTIFLETE-';

        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            return $prefix . $year . '1';
        } else {
            // Extraer el número y aumentarlo

            $number = (int) substr($lastCode->nro_quote, 12);
            $number++;
            return $prefix . $year . $number;
        }
    }



    protected $fillable = [
        'nro_quote',
        'shipping_date',
        'response_date',
        'origin',
        'destination',
        'commodity',
        'packaging_type',
        'load_type',
        'container_type',
        'ton_kilogram',
        'cubage_kgv',
        'total_weight',
        'packages',
        'measures',
        'ocean_freight',
        'utility',
        'operations_commission',
        'pricing_commission',
        'nro_operation',
        'state'
    ];


    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }


    public function messages()
    {
        return $this->hasMany(MessageQuoteFreight::class, 'quote_freight_id', 'id');
    }
}
