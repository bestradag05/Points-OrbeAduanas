<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteFreight extends Model
{
    use HasFactory;

    protected $table = 'quote_freight';

    protected $fillable = [
        'nro_quote',
        'shipping_date',
        'response_date',
        'origin',
        'destination',
        'commodity',
        'packaging_type',
        'load_type',
        'container_type',
        'ton_kilogram',
        'cubage_kgv',
        'total_weight',
        'packages',
        'measures',
        'nro_operation',
        'state'
    ];
}
