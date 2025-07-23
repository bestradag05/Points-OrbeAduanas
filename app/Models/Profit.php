<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    use HasFactory;

    protected $fillable = [
        'profitability_id',        // Relaciona con el servicio (flete, transporte, aduanas)
        'profitability_type',      // Tipo del servicio (flete, transporte, aduanas)
        'personal_id',               // Vendedor que generó el profit
        'seller_profit',           // 50% para el vendedor
        'company_profit',          // 50% para la empresa
        'total_profit',            // Ganancia total generada por el servicio
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    public function profitability()
    {
        return $this->morphTo();  // Relaciona con el modelo correspondiente (flete, transporte, aduanas)
    }
}
