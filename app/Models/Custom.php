<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Custom extends Model
{
    use HasFactory;

    protected $table = 'custom';

    protected $fillable = [
        'nro_operation_custom',
        'nro_dua',
        'nro_dam',
        'date_register',
        'cif_value',
        'channel',
        'nro_bl',
        'value_utility',
        'net_amount',
        'sub_total_value_sale',
        'igv',
        'value_sale',
        'profit',
        'customs_taxes',
        'regularization_date',
        'customs_perception',
        'state',
        'id_modality',
        'nro_quote_commercial'
    ];



    protected $casts = [
        'value_sale' => 'float',
    ];


    // Evento que se ejecuta antes de guardar el modelo
    protected static function booted()
    {
        static::creating(function ($custom) {
            // Si no tiene un número de operación, generarlo
            if (empty($custom->nro_operation_custom)) {
                $custom->nro_operation_custom = $custom->generateNroOperation();
            }
        });
    }

    // Método para generar el número de operación
    public function generateNroOperation()
    {
        // Obtener el último registro
        $lastCode = self::latest('id')->first();
        $year = date('y');
        $prefix = 'ADUA-';

        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            return $prefix . $year . '1';
        } else {
            // Extraer el número y aumentarlo
            $number = (int) substr($lastCode->nro_operation_custom, 7);
            $number++;
            return $prefix . $year . $number;
        }
    }



    public function concepts()
    {
        return $this->belongsToMany(Concept::class, 'concepts_customs', 'id_customs', 'concepts_id')
            ->withPivot(['value_concept',  'value_sale']);
    }

    public function routing()
    {
        return $this->belongsTo(Routing::class, 'nro_operation', 'nro_operation');
    }


    public function commercial_quote()
    {
        return $this->belongsTo(CommercialQuote::class, 'nro_quote_commercial', 'nro_quote_commercial');
    }


    public function modality()
    {
        return $this->belongsTo(Modality::class, 'id_modality', 'id');
    }

    public function insurance()
    {
        return $this->morphOne(Insurance::class, 'insurable', 'model_insurable_service', 'id_insurable_service');
    }

    public function sellerCommissions()
    {
        return $this->morphMany(SellersCommission::class, 'commissionable');
    }
}
