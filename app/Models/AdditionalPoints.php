<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalPoints extends Model
{
    use HasFactory;

    protected $table = 'additional_points';

    protected $fillable = [
        'date_register',
        'bl_to_work',
        'ruc_to_invoice',
        'invoice_number',
        'type_of_service',
        'amount',
        'igv',
        'total',
        'points',
        'id_additional_service',
        'model_additional_service',
        'state',
    ];


    public function additional()
    {
        return $this->morphTo(__FUNCTION__,'model_additional_service', 'id_additional_service');
    }


}
