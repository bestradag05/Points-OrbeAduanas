<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateCountry extends Model
{
    use HasFactory;

    protected $table = 'state_country';

    protected $fillable = ['name', 'id_country', 'state'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'id_country');
    }
}
