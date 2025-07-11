<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackingType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'packing_types';

    protected $fillable = ['name'];


    public function consolidatedCargos()
    {
        return $this->hasMany(ConsolidatedCargos::class, 'id_packaging_type', 'id');
    }

    public function commercialQuotes()
    {
        return $this->hasMany(CommercialQuote::class, 'id_packaging_type', 'id');
    }

    public function commercialQuoteContainers()
    {
        return $this->hasMany(CommercialQuoteContainer::class, 'id_packaging_type', 'id');
    }
}
