<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modality extends Model
{
    use HasFactory;

    protected $table = 'modality';

    protected $fillable = ['name', 'description'];


    public function routing()
    {
        return $this->hasOne(Routing::class, 'id', 'id_modality');
    }
}
