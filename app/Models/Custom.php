<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    use HasFactory;

    protected $table = 'customs';

    protected $fillable = ['nro_orde', 'ruc', 'nro_dam', 'date_register', 'regime','cif_value', 'channel', 'nro_bl', 'regularization_date', 'id_modality', 'id_type_shipment', 'id_user'];
}