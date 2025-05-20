<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreightDocuments extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'path',
        'id_freight',
    ];


    public function freight()
    {
        return $this->belongsTo(Freight::class, 'id_freight');
    }
}
