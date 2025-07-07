<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $table = 'commissions';

    protected $fillable = ['name', 'default_amount', 'description'];

    public function quoteFreightResponses()
    {
        return $this->belongsToMany(ResponseFreightQuotes::class, 'commission_quote_freight_response')
            ->withPivot('amount')
            ->withTimestamps();
    }
}
