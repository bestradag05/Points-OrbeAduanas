<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = ['document_number', 'name_businessname', 'address', 'contact_name', 'contact_number', 'contact_email', 'state', 'id_document'];


    public function consolidatedCargos()
    {
        return $this->hasMany(ConsolidatedCargos::class, 'supplier_id', 'id');
    }
}
