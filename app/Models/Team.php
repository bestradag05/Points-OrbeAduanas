<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'state'];

    // Teams ↔ Areas (many-to-many)
    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(Area::class, 'area_team')->withTimestamps();
    }

    // Team → Personal (one-to-many)
    public function personals(): HasMany
    {
        return $this->hasMany(Personal::class);
    }
}
