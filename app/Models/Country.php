<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'country';

    protected $fillable = ['name','state'];

    public function statesCountry()
    {
        return $this->hasMany(StateCountry::class, 'id');
    }

}
