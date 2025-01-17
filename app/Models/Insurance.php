<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $table = 'insurance';

    protected $fillable = [
        'certified_number',
        'insured_references',
        'date',
        'insurance_value', // valor neto del seguro
        'insurance_value_added', // valor agregado del asesor
        'insurance_sale', // Valor venta del seguro (suma de valor del seguro + el valor agregado por el asesor)
        'sales_value', // valor venta prima ( valor venta del seguro + igv)
        'sales_price', // precio de venta ( valor venta del seguro + valor venta prima)
        'id_type_insurance',
        'id_insurable_service',
        'model_insurable_service',
        'name_service',
        'state'
    ];



    public function insurable()
    {
        return $this->morphTo(__FUNCTION__, 'model_insurable_service', 'id_insurable_service');
    }


    public function typeInsurance()
    {
        return $this->belongsTo(TypeInsurance::class, 'id_type_insurance');
    }
}
