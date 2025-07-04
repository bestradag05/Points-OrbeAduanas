<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airline extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'contact',
        'cellphone',
        'email',
        'status'
    ];

    public function ResponseFreightQuote(){
        return $this->hasMany(ResponseFreightQuotes::class, 'shipping_company_id', 'id');
    }
}
