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
        'cost_gang',
        'guard',
        'cost_guard',
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
        'old_cost_transport',
        'cost_transport',
        'readjustment_reason',
        'withdrawal_date',
        'observations',
        'state'
    ];



    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }


    public function transport()
    {
        return $this->belongsTo(Transport::class, 'id', 'id_quote_transport');
    }

}
