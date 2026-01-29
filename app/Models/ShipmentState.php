<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentState extends Model
{
    use HasFactory;

    protected $table = 'shipment_states';

    protected $fillable = [
        'state',
        'description'
    ];
}
