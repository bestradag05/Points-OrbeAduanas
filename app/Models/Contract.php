<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contract';

    protected $fillable = ['id_personal','start_date','end_date','sueldo','user_register','user_update','state'];
}
