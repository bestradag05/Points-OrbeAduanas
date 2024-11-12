<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $table = 'transport';

    protected $fillable = ['nro_orden', 'date_register', 'invoice_number', 'nro_dua', 'origin', 'destination', 'transport_value', 'added_value',  'tax_base', 'igv', 'total', 'additional_points', 'state', 'payment_state', 'payment_date',  'weight', 'nro_operation', 'id_supplier'];


    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }

    public function additional_point()
    {
        return $this->morphMany(AdditionalPoints::class, 'additional', 'model_additional_service', 'id_additional_service');
    }
    

}
