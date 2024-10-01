<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = ['ruc', 'name_businessname', 'contact_name', 'contact_number', 'contact_email','id_user'];


     // Relación uno a uno inversa con el modelo Personal
     public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function userCustomer()
    {
        return $this->hasOneThrough(Personal::class, User::class, 'id', 'id');
    }

}
