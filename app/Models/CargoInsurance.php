<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoInsurance extends Model
{
    use HasFactory;

    protected $table = 'cargo_insurance';

    protected $fillable = ['certified_number', 'insured_references', 'date', 'insurance_sale', 'sales_value', 'sales_price', 'id_type_insurance'];
}
