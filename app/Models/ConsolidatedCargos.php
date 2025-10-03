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
        'id_incoterms',
        'supplier_id',
        'supplier_temp',
        'commodity',
        'load_value',
        'nro_packages',
        'id_packaging_type',
        'weight',
        'unit_of_weight',
        'volumen_kgv',
        'unit_of_volumen_kgv',
        'value_measures',
    ];


    public function commercialQuote()
    {
        return $this->belongsTo(CommercialQuote::class, 'commercial_quote_id', 'id');
    }

    public function incoterm()
    {
        return $this->belongsTo(Incoterms::class, 'id_incoterms', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function packingType()
    {
        return $this->belongsTo(PackingType::class, 'id_packaging_type', 'id');
    }
}
