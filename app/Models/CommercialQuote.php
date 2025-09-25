<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialQuote extends Model
{
    use HasFactory;

    protected $table = 'commercial_quote';

    protected $fillable = [

        'nro_quote_commercial',
        'origin',
        'destination',
        /*  'customer_company_name',
        'contact',
        'cellphone',
        'email', */
        'load_value',
        'id_personal',
        'id_type_shipment',
        'id_regime',
        'id_incoterms',
        'id_type_load',
        'id_customer',
        'id_supplier',
        'lcl_fcl',
        'is_consolidated',
        'commodity',
        'nro_package',
        'id_packaging_type',
        'kilograms',
        'volumen',
        'pounds',
        'kilogram_volumen',
        'tons',
        'measures',
        'cif_value',
        'valid_until',
        'services_to_quote',
        'state',
    ];

    protected $casts = [
        'valid_until' => 'date', // Convierte 'valid_until' en un objeto Carbon
        'services_to_quote' => 'array',
    ];



    // Evento que se ejecuta antes de guardar el modelo
    protected static function booted()
    {
        static::creating(function ($commercialQuote) {
            // Si no tiene un número de operación, generarlo
            if (empty($commercialQuote->nro_quote_commercial)) {
                $commercialQuote->nro_quote_commercial = $commercialQuote->generateNroQuoteCommercial();
            }
        });
    }

    public function generateNroQuoteCommercial()
    {
        $lastCode = self::latest('id')->first();
        $prefix = 'TCOST';

        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            $number = 1;
        } else {
            // Extraer el número y aumentarlo
            $number = (int) substr($lastCode->nro_quote_commercial, 5);
            $number++;
        }

        // Formatear el número con ceros a la izquierda
        $codigo = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);

        return $codigo;
    }


    public function originState()
    {
        return $this->belongsTo(StateCountry::class, 'origin');
    }

    public function destinationState()
    {
        return $this->belongsTo(StateCountry::class, 'destination');
    }
    public function type_shipment()
    {
        return $this->belongsTo(TypeShipment::class, 'id_type_shipment', 'id');
    }
    public function incoterm()
    {
        return $this->belongsTo(Incoterms::class, 'id_incoterms', 'id');
    }

    public function type_load()
    {
        return $this->belongsTo(TypeLoad::class, 'id_type_load', 'id');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id');
    }


    public function regime()
    {
        return $this->belongsTo(Regime::class, 'id_regime', 'id');
    }

    public function containers()
    {
        return $this->belongsTo(Container::class, 'id_containers');
    }


    public function containersFcl()
    {
        return $this->belongsToMany(Container::class, 'commercial_quote_containers', 'commercial_quote_id', 'containers_id')
            ->withPivot('container_quantity', 'commodity', 'nro_package', 'id_packaging_type', 'kilograms', 'volumen', 'measures')
            ->withTimestamps();
    }

    public function commercialQuoteContainers()
    {
        return $this->hasMany(CommercialQuoteContainer::class, 'commercial_quote_id');
    }

    public function typeService()
    {
        return $this->belongsToMany(TypeService::class, 'commercialquote_typeservice', 'id_commercial_quote', 'id_type_service');
    }

    public function custom()
    {
        return $this->hasOne(Custom::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }

    public function freight()
    {
        return $this->hasOne(Freight::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }

    public function transport()
    {
        return $this->hasOne(Transport::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }

    public function quote_freight()
    {
        return $this->hasMany(QuoteFreight::class, 'nro_quote_commercial', 'nro_quote_commercial'); // 'routing_id' es la clave foránea en la tabla cotizaciones
    }

    public function quote_transport()
    {
        return $this->hasMany(QuoteTransport::class, 'nro_quote_commercial', 'nro_quote_commercial'); // 'routing_id' es la clave foránea en la tabla cotizaciones
    }

    public function consolidatedCargos()
    {
        return $this->hasMany(ConsolidatedCargos::class, 'commercial_quote_id', 'id');
    }

    public function concept()
    {
        return $this->belongsToMany(
            Concept::class,
            'commercial_quote_concept',      // nombre de la tabla pivote
            'commercial_quote_id',           // FK en la pivote hacia commercial_quote
            'concepts_id'                     // FK en la pivote hacia concepts
        );
    }

    public function packingType()
    {
        return $this->belongsTo(PackingType::class, 'id_packaging_type', 'id');
    }

    public function quotesSentClients()
    {
        return $this->hasMany(QuotesSentClient::class, 'commercial_quote_id');
    }


}
