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
            'contact_phone',
            'contact_name',
            'max_attention_hour',
            'gang',
            'packaging_type',
            'stackable',
            'nro_operation',
            'comment',
            'state'
    ];
}
