<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceRates extends Model
{
    use HasFactory;

    protected $fillable = [
        'insurance_type_id',
        'shipment_type_description',
        'min_value',
        'fixed_cost',
        'percentage',
    ];


    public function insuranceType()
    {
        return $this->belongsTo(TypeInsurance::class, 'insurance_type_id');
    }


}
