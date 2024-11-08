<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Custom extends Model
{
    use HasFactory;

    protected $table = 'custom';

    protected $fillable = ['nro_orde', 'nro_dua','nro_dam', 'date_register', 'cif_value', 'channel', 'nro_bl', 'total_custom', 'regularization_date', 'state', 'id_modality', 'nro_operation'];




    public function concepts()
    {
        return $this->belongsToMany(Concepts::class, 'concepts_customs', 'id_customs', 'id_concepts');
    }

    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
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
        return $this->morphOne(AdditionalPoints::class, 'additional', 'model_additional_service', 'id_additional_service');
    }

}
