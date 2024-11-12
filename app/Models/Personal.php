<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [  
    'document_number',
    'names',
    'last_name',
    'mother_last_name',
    'birthdate',
    'civil_status',
    'sexo',
    'cellphone',
    'email',
    'address',
    'img_url',
    'state',
    'id_user',
    'id_document'];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'id_document', 'id');
    }

    public function routing(){
        return $this->hasMany(Routing::class, 'id_personal', 'id');
    }

}
