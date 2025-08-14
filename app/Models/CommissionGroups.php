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
}
