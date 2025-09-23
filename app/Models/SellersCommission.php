<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellersCommission extends Model
{
    use HasFactory;

    protected $table = 'sellers_commission';

    protected $fillable = [
        'commissionable_id',
        'commissionable_type',
        'commission_group_id',
        'personal_id',
        'cost_of_sale',
        'net_cost',
        'utility',
        'insurance',
        'gross_profit',
        'pure_points',
        'additional_points',
        'seller_profit',
        'company_profit',
        'remaining_balance',
        'generated_commission',
        'is_adjusted'
    ];

    // Relación con el modelo `Personal`
    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    // Relación polimórfica con el modelo asociado (Freight, Transporte, Aduana, etc.)
    public function commissionable()
    {
        return $this->morphTo();
    }

    public function commissionsGroup()
    {
        return $this->belongsTo(CommissionGroups::class, 'commission_group_id');
    }
}
