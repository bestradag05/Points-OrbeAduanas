<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentStateDocument extends Model
{
    use HasFactory;

    protected $table = 'shipment_state_documents';

    protected $fillable = [
        'shipment_state_id',
        'document_name',
        'file_path',
    ];
}
