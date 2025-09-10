<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freight extends Model
{
    use HasFactory;


    protected $table = 'freight';

    protected $fillable =
    [
        'nro_operation_freight',
        'wr_loading',
        'roi',
        'hawb_hbl',
        'bl_work',
        'date_register',
        'edt',
        'eta',
        'value_utility',
        'accepted_answer_value',
        'total_answer_utility',
        'value_sale',
        'profit',
        /*         'total_additional_points',
        'total_additional_points_used', */
        'state',
        'id_quote_freight',
        'nro_operation',
        'nro_quote_commercial'
    ];


    // Evento que se ejecuta antes de guardar el modelo
    protected static function booted()
    {
        static::creating(function ($freight) {
            // Si no tiene un número de operación, generarlo
            if (empty($freight->nro_operation_freight)) {
                $freight->nro_operation_freight = $freight->generateNroOperation();
            }
        });
    }

    // Método para generar el número de operación
    public function generateNroOperation()
    {
        // Obtener el último registro
        $lastCode = self::latest('id')->first();
        $year = date('y');
        $prefix = 'FLETE-';
        
        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            return $prefix . $year . '1';
        } else {
            // Extraer el número y aumentarlo
            $number = (int) substr($lastCode->nro_operation_freight, 8);
            $number++;
            return $prefix . $year . $number;
        }
    }



    public function concepts()
    {
        return $this->belongsToMany(Concept::class, 'concepts_freight', 'id_freight', 'concepts_id')
            ->withPivot(['value_concept', 'has_igv']);
    }


    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }

    public function commercial_quote()
    {
        return $this->belongsTo(CommercialQuote::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }

    public function insurance()
    {
        return $this->morphOne(Insurance::class, 'insurable', 'model_insurable_service', 'id_insurable_service');
    }

    public function points()
    {
        return $this->morphMany(Points::class, 'pointable'); // Relaciona con el modelo Point
    }

    public function sellerCommissions()
    {
        return $this->morphMany(SellersCommission::class, 'commissionable');
    }

    public function profitability()
    {
        return $this->morphOne(Profit::class, 'profitability');  // 'profitability' corresponde a la relación polimórfica
    }

    public function quoteFreight()
    {
        return $this->hasOne(QuoteFreight::class, 'id', 'id_quote_freight');
    }

    public function documents()
    {
        return $this->hasMany(FreightDocuments::class, 'id_freight');
    }
}
