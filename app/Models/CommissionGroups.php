<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionGroups extends Model
{
    use HasFactory;

    protected $table = 'commission_groups';

    protected $fillable = [
        'process_management_id',
        'total_commission',
        'total_profit',
        'total_points_pure',
        'total_points_additional',
        'total_points'
    ];

    public function processManagement()
    {
        return $this->belongsTo(ProcessManagement::class, 'process_management_id');
    }

    public function sellerCommissions()
    {
        return $this->hasMany(SellersCommission::class, 'commission_group_id');
    }
}
