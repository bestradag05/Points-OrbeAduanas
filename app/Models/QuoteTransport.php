<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteTransport extends Model
{
    use HasFactory;

    protected $table = 'quote_transport';

    protected $fillable = [
        'nro_quote',
        'pick_up',
        'delivery',
        'container_return',
        'gang',
        'guard',
        'commodity',
        'packaging_type',
        'load_type',
        'container_type',
        'ton_kilogram',
        'stackable',
        'cubage_kgv',
        'total_weight',
        'packages',
        'measures',
        'lcl_fcl',
        'id_type_shipment',
        'cost_transport',
        'observations',
        'state',
        'nro_operation',
        'nro_quote_commercial',
    ];



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
        $prefix = 'COTITRAN-';

        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            return $prefix . $year . '1';
        } else {
            // Extraer el número y aumentarlo

            $number = (int) substr($lastCode->nro_quote, 11);
            $number++;
            return $prefix . $year . $number;
        }
    }



    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }

    public function commercial_quote()
    {
        return $this->belongsTo(CommercialQuote::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }


    public function transport()
    {
        return $this->belongsTo(Transport::class, 'id', 'id_quote_transport');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function type_shipment()
    {
        return $this->belongsTo(TypeShipment::class, 'id_type_shipment', 'id');
    }

    public function messages()
    {
        return $this->hasMany(MessageQuoteTransport::class, 'quote_transport_id', 'id');
    }
}
