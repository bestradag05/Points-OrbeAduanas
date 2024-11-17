<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupplierDocument extends Model
{
    use HasFactory;

    protected $table = 'customer_supplier_documents';

    protected $fillable = ['name', 'number_digits', 'state'];
}
