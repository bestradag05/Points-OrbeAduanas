<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type_container_id',
        'description',
        'length',
        'width',
        'height',
        'max_load',
        'state'
    ];
    
    protected $dates = [
        'created_at',
        'updated_at'
    ];


    protected static function booted()
    {
        static::saving(function ($container) {
            $container->volume = $container->length * $container->width * $container->height;
        });
    }

    protected $casts = [
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'max_load' => 'decimal:2',
        'volume' => 'decimal:2'
    ];



    public function typeContainer()
    {
        return $this->belongsTo(TypeContainer::class, 'type_container_id');
    }

    public function commercialQuotes()
    {
        return $this->hasMany(CommercialQuote::class, 'id');
    }


}

