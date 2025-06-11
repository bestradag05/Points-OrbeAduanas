<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseFreightQuotes extends Model
{
    use HasFactory;

        protected $table = 'response_freight_quotes'; 

     protected $fillable = [
        'validity_date',
        'origin',
        'destination',
        'frequency',
        'service',
        'transit_time',
        'exchange_rate'
    ];
}
