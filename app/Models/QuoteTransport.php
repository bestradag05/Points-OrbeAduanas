<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concept;


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
        'cost_gang',
        'guard',
        'cost_guard',
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
        'withdrawal_date',
        'observations',
        'state',
        'nro_operation',
        'nro_quote_commercial',
        'quote_transport_response',     
        'quote_transport_id',
        'response_quote_id',
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
        return $this->belongsTo(Transport::class, 'id', 'quote_transport_id');
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


    public function setCostTransportAttribute($value)
    {
        $this->attributes['cost_transport'] = $value;
        // Calcular total_transport si es necesario
        $this->attributes['total_transport'] = $value + ($this->transportConcepts->sum('pivot.added_value') ?? 0);
    }

    public function responseTransportQuotes()
    {
        return $this->hasMany(
            ResponseTransportQuote::class,
            'quote_transport_id',     // FK hacia quote_transport
            'id'
        );
    }

    public function transportConcepts()
    {
        return $this->belongsToMany(
            Concept::class,
            'concepts_quote_transport',      // tu tabla de pivot
            'quote_transport_id',           // FK en pivot hacia esta tabla
            'concepts_id');
    }


}
