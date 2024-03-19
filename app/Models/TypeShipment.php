<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeShipment extends Model
{
    use HasFactory;

    protected $table = 'type_shipment';

    protected $fillable = ['code', 'description'];
}
