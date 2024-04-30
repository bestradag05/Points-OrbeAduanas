<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routing extends Model
{
    use HasFactory;


    protected $table = 'routing';

    protected $fillable = ['nro_operation', 'origin', 'destination', 'freight_value', 'load_value', 'insurance_value', 'id_personal', 'id_customer',
                           'id_type_shipment', 'lcl_fcl', 'id_modality', 'id_regime', 'id_incoterms', 'id_supplier', 'commodity', 'nro_package', 'pounds', 'kilograms', 
                            'meassurement', 'hs_code', 'observation', 'concepts'];

    protected $casts = [
    'load_value' => 'decimal:2',
    ];


    
    public function type_shipment()
    {
        return $this->belongsTo(TypeShipment::class, 'id_type_shipment', 'id');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function regime()
    {
        return $this->belongsTo(Regime::class, 'id_regime', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id');
    }

    public function typeService()
    {
        return $this->belongsToMany(TypeService::class, 'routing_typeservice', 'id_routing', 'id_type_service');
    }

    public function custom()
    {
        return $this->hasOne(Custom::class, 'nro_operation', 'nro_operation');
    }

    public function freight()
    {
        return $this->hasOne(Freight::class, 'nro_operation', 'nro_operation');
    }

    public function transport()
    {
        return $this->hasOne(Transport::class, 'nro_operation', 'nro_operation');
    }


}
