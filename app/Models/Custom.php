<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Custom extends Model
{
    use HasFactory;

    protected $table = 'custom';

    protected $fillable = ['nro_orde', 'nro_dua','nro_dam', 'date_register', 'cif_value', 'channel', 'nro_bl', 'regularization_date', 'state', 'id_modality','nro_operation'];




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

}
