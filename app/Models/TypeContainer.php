<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeContainer extends Model
{
    use HasFactory;

    protected $table = 'type_containers';

    protected $fillable = ['name', 'description', 'state'];
}
