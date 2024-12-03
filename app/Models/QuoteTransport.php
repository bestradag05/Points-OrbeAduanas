<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteTransport extends Model
{
    use HasFactory;

    protected $table = 'quote_transport';

    protected $fillable = [
        'shipping_date',
        'response_date',
        'pick_up',
        'delivery',
        'container_return',
        'contact_phone',
        'contact_name',
        'max_attention_hour',
        'gang',
        'guard',
        'customer_detail',
        'commodity',
        'packaging_type',
        'load_type',
        'container_type',
        'ton_kilogram',
        'stackable',
        'cubage_kgv',
        'total_weight',
        'packages',
        'cargo_detail',
        'measures',
        'nro_operation',
        'lcl_fcl',
        'state'
    ];



    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }
}
