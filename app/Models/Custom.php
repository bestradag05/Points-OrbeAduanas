<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    use HasFactory;

    protected $table = 'custom';

    protected $fillable = ['nro_orde', 'nro_dam', 'date_register', 'cif_value', 'channel','nro_bl', 'regularization_date', 'state', 'nro_operation'];
}