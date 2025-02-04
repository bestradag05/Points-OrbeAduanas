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
        'commodity',
        'nro_package',
        'packaging_type',
        'container_type',
        'kilograms',
        'volumen',
        'kilogram_volumen',
        'tons',
        'measures',
        'observation',
        'state',
  

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
        return $this->belongsToMany(TypeService::class, 'routing_typeservice', 'id_routing', 'id_type_service');
    }


}
