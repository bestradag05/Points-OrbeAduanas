<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeShipment extends Model
{
    use HasFactory;

    protected $table = 'type_shipment';

    protected $fillable = ['name', 'description', 'status'];



    public function quoteTransport()
    {
        return $this->hasOne(QuoteTransport::class, 'id_customer', 'id');
    }
}
