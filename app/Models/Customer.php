<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = ['document_number','name_businessname','address','contact_name','contact_number','contact_email','state','id_document','id_personal'];



    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal');
    }

    public function document()
    {
        return $this->belongsTo(CustomerSupplierDocument::class, 'id_document', 'id');
    }

}
