<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoInsurance extends Model
{
    use HasFactory;

    protected $table = 'cargo_insurance';

    protected $fillable = ['certified_number', 'insured_references', 'date', 'sales_value', 'igv', 'id_type_insurance'];
}
