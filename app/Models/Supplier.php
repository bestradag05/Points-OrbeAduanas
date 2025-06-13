<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'name_businessname',
        'area_type',
        'provider_type',
        'address',
        'contact_name',
        'contact_number',
        'contact_email',
        'document_number',
        'document_type',
        'cargo_type',
        'unit',
        'country',
        'city',
        'state',
    ];


    public function consolidatedCargos()
    {
        return $this->hasMany(ConsolidatedCargos::class, 'supplier_id', 'id');
    }


    public function commercialQuotes()
    {
        return $this->hasMany(CommercialQuote::class);
    }
    public function transportResponses()
    {
        return $this->hasMany(ResponseTransportQuote::class, 'provider_id');
    }
}
