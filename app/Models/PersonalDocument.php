<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDocument extends Model
{
    use HasFactory;

    protected $table = 'personal_documents';

    protected $fillable = ['name', 'number_digits', 'state'];

}
