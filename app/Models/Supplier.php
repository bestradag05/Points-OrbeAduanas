<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = ['type_id', 'number_id', 'name_businessname', 'addres', 'contact_name', 'contact_number', 'contact_email', 'type_suppliers'];
}
