<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomDistrict extends Model
{
    use HasFactory;

    protected $table = 'customs_districts';

    protected $fillable = ['code', 'name', 'description', 'status'];

}
