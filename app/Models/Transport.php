<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $table = 'transport';

    protected $fillable = ['nro_orden', 'date','invoice_number', 'nro_dua', 'address', 'tax_base', 'igv', 'total', 'state', 'weight','nro_operation', 'id_suppliers'];


    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }


}
