<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'companys';
    protected $fillable = ['ruc', 'business_name', 'address', 'manager', 'phone', 'email', 'user_register', 'user_update', 'avatar', 'estate'];
}
