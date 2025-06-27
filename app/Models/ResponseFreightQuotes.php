<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseFreightQuotes extends Model
{
    use HasFactory;

    protected $table = 'response_freight_quotes';

    protected $fillable = [
        'nro_response',
        'validity_date',
        'id_supplier',
        'airline',
        'shipping_company',
        'origin',
        'destination',
        'frequency',
        'service',
        'transit_time',
        'exchange_rate',
        'total',
        'id_quote_freight',
        'status'
    ];


    protected $casts = [
        'validity_date' => 'date',
    ];


    // Evento que se ejecuta antes de guardar el modelo
    protected static function booted()
    {
        static::creating(function ($response) {
            // Si no tiene un número de respuesta, generarlo
            if (empty($response->nro_response)) {
                $response->nro_response = $response->generateNroResponse();
            }
        });
    }

    // Método para generar el número de operación
    public function generateNroResponse()
    {
        // Obtener el último registro
        $lastCode = self::latest('id')->first();
        $year = date('y');
        $prefix = 'RESPFLETE-';

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

    /* accessors */


    public function getValidityDateFormattedAttribute()
    {
        return $this->validity_date?->format('d/m/Y');
    }


    public function quote()
    {
        return $this->belongsTo(QuoteFreight::class, 'id_quote_freight');
    }


    public function concepts()
    {
        return $this->belongsToMany(Concept::class, 'concepts_response_freight', 'response_freight_id', 'concept_id')
            ->withPivot(['unit_cost', 'fixed_miltiplyable_cost', 'observations', 'final_cost']);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }


    public function commissions()
    {
        return $this->belongsToMany(Commission::class, 'commission_quote_freight_response')
            ->withPivot('amount')
            ->withTimestamps();
    }
}
