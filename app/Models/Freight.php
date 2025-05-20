<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freight extends Model
{
    use HasFactory;


    protected $table = 'freight';

    protected $fillable =
    [
        'wr_loading',
        'roi',
        'hawb_hbl',
        'bl_work',
        'date_register',
        'edt',
        'eta',
        'value_utility',
        'value_freight',
        'state',
        'id_quote_freight',
        'nro_operation',
        'nro_quote_commercial'
    ];



    public function concepts()
    {
        return $this->belongsToMany(Concepts::class, 'concepts_freight', 'id_freight', 'id_concepts')
            ->withPivot(['value_concept', 'value_concept_added', 'total_value_concept', 'additional_points']);
    }


    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }

    public function commercial_quote()
    {
        return $this->belongsTo(CommercialQuote::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }

    public function insurance()
    {
        return $this->morphOne(Insurance::class, 'insurable', 'model_insurable_service', 'id_insurable_service');
    }

    public function additional_point()
    {
        return $this->morphMany(AdditionalPoints::class, 'additional', 'model_additional_service', 'id_additional_service');
    }

    public function quoteFreight()
    {
        return $this->hasMany(QuoteFreight::class, 'id', 'id_quote_freight');
    }

    public function documents()
    {
        return $this->hasMany(FreightDocuments::class, 'id_freight');
    }
}
