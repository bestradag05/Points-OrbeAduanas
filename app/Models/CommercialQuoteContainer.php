<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialQuoteContainer extends Model
{
    use HasFactory;

    protected $table = 'commercial_quote_containers';

    protected $fillable = [
        'commercial_quote_id',
        'containers_id',
        'container_quantity',
        'commodity',
        'nro_package',
        'id_packaging_type',
        'load_value',
        'weight',
        'unit_of_weight',
        'volumen_kgv',
        'unit_of_volumen_kgv',
        'measures'
    ];

    public function commercialQuote()
    {
        return $this->belongsTo(CommercialQuote::class, 'commercial_quote_id');
    }

    public function container()
    {
        return $this->belongsTo(Container::class, 'containers_id');
    }

    public function packingType()
    {
        return $this->belongsTo(PackingType::class, 'id_packaging_type', 'id');
    }
}
