<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = ['name', 'last_name', 'cellphone', 'email', 'dni', 'immigration_card', 'passport', 'img_url', 'id_user'];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function routing(){
        return $this->hasMany(Routing::class, 'id_personal', 'id');
    }

}
