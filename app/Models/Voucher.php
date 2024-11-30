<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    protected $fillable = [
            'ruc',
            'name_businessname',
            'serial_number',
            'total_amount',
            'type_of_receipt',
            'document_url',
            'id_settlement'
    ];
}
