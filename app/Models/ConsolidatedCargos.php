<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsolidatedCargos extends Model
{
    use HasFactory;

    protected $table = 'consolidated_cargos';

    protected $fillable =
    [       
            'commercial_quote_id',
            'supplier_id',
            'supplier_temp',
            'commodity',
            'load_value',
            'nro_packages',
            'packaging_type',
            'kilogram_volumen',
            'volumen',
            'kilograms',
            'value_measures',
    ];


    public function commercialQuote()
    {
        return $this->belongsTo(CommercialQuote::class, 'commercial_quote_id', 'id');
    }


}
