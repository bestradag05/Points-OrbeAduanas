<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Money extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'moneys';
    protected $fillable = ['money', 'description', 'user_register', 'user_update', 'estate'];
}
