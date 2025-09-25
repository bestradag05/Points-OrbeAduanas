<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessManagement extends Model
{
    use HasFactory;

    protected $table = 'process_management';

    protected $fillable = [
        'nro_quote_commercial',
        'state',
        'freight_status',
        'customs_status',
        'transport_status',
        'process_completed',
    ];


    public function commercialQuote()
    {
        return $this->belongsTo(CommercialQuote::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }

    public function commissionGroup()
    {
        return $this->hasOne(CommissionGroups::class, 'process_management_id');
    }

    // Relación con el flete
    public function freight()
    {
        return $this->hasOne(Freight::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }

    // Relación con la aduana
    public function customs()
    {
        return $this->hasOne(Custom::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }

    // Relación con el transporte
    public function transport()
    {
        return $this->hasOne(Transport::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }
}
