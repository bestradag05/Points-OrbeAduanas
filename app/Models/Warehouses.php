<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouses extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'name_businessname',
        'contact_name',
        'contact_number',
        'contact_email',
        'warehouses_type',
        'status'
    ];

    public function quoteTransportsPickup()
    {
        return $this->hasMany(QuoteTransport::class, 'pickup_warehouse');
    }

    public function quoteTransportsDelivery()
    {
        return $this->hasMany(QuoteTransport::class, 'delivery_warehouse');
    }
}
