<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeLoad extends Model
{
    use HasFactory;

    protected $table = 'type_load';

    protected $fillable = ['name', 'description', 'state'];
}
