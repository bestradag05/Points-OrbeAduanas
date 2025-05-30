<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regime extends Model
{
    use HasFactory;

    protected $table = 'regime';
    protected $fillable = ['code', 'description', 'state'];

    public function regime()
    {
        return $this->belongsTo(Regime::class, 'code');
    }
}
