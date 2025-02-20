<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Custom extends Model
{
    use HasFactory;

    protected $table = 'custom';

    protected $fillable = [
        'nro_orde', 
        'nro_dua',
        'nro_dam', 
        'date_register', 
        'cif_value', 
        'channel', 
        'nro_bl', 
        'total_custom', 
        'regularization_date', 
        'state', 
        'id_modality', 
        'nro_quote_commercial'
    ];




    public function concepts()
    {
        return $this->belongsToMany(Concepts::class, 'concepts_customs', 'id_customs', 'id_concepts');
    }

    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }


    public function commercial_quote()
    {
        return $this->belongsTo(CommercialQuote::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }


    public function modality()
    {
        return $this->belongsTo(Modality::class, 'id_modality', 'id');
    }

    public function insurance()
    {
        return $this->morphOne(Insurance::class, 'insurable', 'model_insurable_service', 'id_insurable_service');
    }

    public function additional_point()
    {
        return $this->morphMany(AdditionalPoints::class, 'additional', 'model_additional_service', 'id_additional_service');
    }

}
