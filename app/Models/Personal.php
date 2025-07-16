<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [  
    'document_number',
    'names',
    'last_name',
    'mother_last_name',
    'birthdate',
    'civil_status',
    'sexo',
    'cellphone',
    'email',
    'address',
    'img_url',
    'state',
    'id_user',
    'id_document'];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'id_personal');
    }

    public function document()
    {
        return $this->belongsTo(PersonalDocument::class, 'id_document', 'id');
    }

    public function routing(){
        return $this->hasMany(Routing::class, 'id_personal', 'id');
    }

    public function commercialQuotes(){
        return $this->hasMany(CommercialQuote::class, 'id_personal', 'id');
    }

    public function sellerCommissions()
    {
        return $this->hasMany(SellersCommission::class, 'personal_id');
    }

    public function points()
    {
        return $this->hasMany(Points::class, 'personal_id');
    }

}
