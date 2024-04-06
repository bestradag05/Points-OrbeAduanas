<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepts extends Model
{
    use HasFactory;

    protected $table = 'concepts';

    protected $fillable = ['name', 'id_type_shipment'];

    public function typeService()
    {
        return $this->belongsTo(TypeService::class, 'id_type_service', 'id');
    }

    public function custom()
    {
        return $this->belongsToMany(Custom::class);
    }

    public function freight()
    {
        return $this->belongsToMany(Freight::class);
    }
}