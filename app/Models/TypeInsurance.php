<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeInsurance extends Model
{
    use HasFactory;

    protected $table = 'type_insurance';

    protected $fillable = ['name', 'state'];


    public function insurances()
    {
        return $this->hasMany(Insurance::class, 'id_type_insurance');
    }

}
