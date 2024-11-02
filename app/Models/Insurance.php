<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $table = 'insurance';

    protected $fillable = ['certified_number', 'insured_references', 'date', 'insurance_sale', 'sales_value', 'sales_price', 'id_type_insurance', 'id_insurable_service', 'model_insurable_service',  'name_service', 'state'];



    public function insurable()
    {
        return $this->morphTo(__FUNCTION__,'model_insurable_service', 'id_insurable_service');
    }


    public function typeInsurance()
    {
        return $this->belongsTo(typeInsurance::class, 'id_type_insurance');
    }

}   
