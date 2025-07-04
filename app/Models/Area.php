<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'state'];

    // Areas ↔ Teams (many-to-many)
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'area_team')->withTimestamps();
    }

    // Areas ↔ Personal (many-to-many)
    public function personals()
    {
        return $this->belongsToMany(Personal::class, 'area_personal')->withTimestamps();
    }
}
