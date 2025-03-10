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
            'supplier_id',
            'supplier_temp',
            'commodity',
            'load_value',
            'nro_packages',
            'packaging_type',
            'volumen',
            'kilograms',
            'value_measures',
    ];


}
