<?php

namespace App\Models;

use App\Traits\HasTrace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseFreightQuotes extends Model
{
    use HasFactory;
    use HasTrace;

    protected $table = 'response_freight_quotes';

    protected $fillable = [
        'nro_response',
        'valid_until',
        'id_supplier',
        'airline_id',
        'shipping_company_id',
        'origin',
        'destination',
        'frequency',
        'service',
        'transit_time',
        'free_days',
        'exchange_rate',
        'total',
        'id_quote_freight',
        'status'
    ];


    protected $casts = [
        'valid_until' => 'date',
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
    public static function generateNroResponse()
    {
        // Obtener el último registro
        $lastCode = self::whereNotNull('nro_response')->latest('id')->first();
        $year = date('y');
        $prefix = 'RESPFLETE-';

        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            return $prefix . $year . '1';
        } else {
            // Extraer el número y aumentarlo
            $number = (int) substr($lastCode->nro_response, 12);
            $number++;
            return $prefix . $year . $number;
        }
    }

    /* accessors */


    public function getValidUntilFormattedAttribute()
    {
        return $this->valid_until?->format('d/m/Y');
    }


    public function quote()
    {
        return $this->belongsTo(QuoteFreight::class, 'id_quote_freight');
    }


    public function concepts()
    {
        return $this->belongsToMany(Concept::class, 'concepts_response_freight', 'response_freight_id', 'concept_id')
            ->withPivot(['unit_cost', 'fixed_miltiplyable_cost', 'observations', 'final_cost','has_igv']);
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


    public function traces()
    {
        return $this->morphMany(Trace::class, 'traceable');
    }

    public function shippingCompany(){
        return $this->belongsTo(ShippingCompany::class, 'shipping_company_id', 'id');
    }

    public function airline(){
        return $this->belongsTo(Airline::class, 'airline_id', 'id');
    }
}
