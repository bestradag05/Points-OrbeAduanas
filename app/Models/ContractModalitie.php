<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractModalitie extends Model
{
    use HasFactory;

    protected $table = 'contract_modalities';

    protected $fillable = ['name', 'description', 'format' ,'state'];
}
