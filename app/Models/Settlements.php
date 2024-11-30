<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlements extends Model
{
    use HasFactory;

    protected $table = 'settlements';

    protected $fillable = [
        'nro_order',
        'date',
        'customer',
        'gia_bl',
        'origin',
        'destination',
        'cif_value',
        'number_of_packages',
        'type_of_shipment',
        'regime',
        'dua_number',
        'channel'
    ];
}
