<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSchedule extends Model
{
    use HasFactory;

    protected $table = 'timeSchedule';

    protected $fillable = [
        'heLunes',
        'heMartes',
        'heMiercoles',
        'heJueves',
        'heViernes',
        'heSabado',
        'hsLunes',
        'hsMartes',
        'hsMiercoles',
        'hsJueves',
        'hsViernes',
        'hsSabado',
        'tolerance',
        'dtFechaInicio',
        'dtFechaFin',
        'state',
        'inCodUserCreate',
        'inCodUserEdit',
    ];


}
