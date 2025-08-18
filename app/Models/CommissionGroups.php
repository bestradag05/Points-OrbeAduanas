<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionGroups extends Model
{
    use HasFactory;

    protected $table = 'commission_groups';

    protected $fillable = [
        'commercial_quote_id',
        'total_commission',
        'total_profit',
        'total_points'
    ];

    public function commercialQuote()
    {
        return $this->belongsTo(CommercialQuote::class, 'commercial_quote_id');
    }

    public function sellerCommissions()
    {
        return $this->hasMany(SellersCommission::class, 'commission_group_id');
    }
}
