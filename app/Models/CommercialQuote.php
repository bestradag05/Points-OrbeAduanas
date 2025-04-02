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
        'customer_ruc',
        'customer_company_name',
        'load_value',
        'id_personal',
        'id_type_shipment',
        'id_regime',
        'id_incoterms',
        'id_type_load',
        'lcl_fcl',
        'is_consolidated',
        'total_nro_package_consolidated',
        'total_volumen_consolidated',
        'total_kilogram_consolidated',
        'total_kilogram_volumen_consolidated',
        'commodity',
        'nro_package',
        'packaging_type',
        'container_type',
        'kilograms',
        'volumen',
        'kilogram_volumen',
        'tons',
        'measures',
        'cif_value',
        'valid_date',
        'state',
  

    ];

    protected $casts = [
        'valid_date' => 'date', // Convierte 'valid_date' en un objeto Carbon
    ];


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

    public function regime()
    {
        return $this->belongsTo(Regime::class, 'id_regime', 'id');
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

}
