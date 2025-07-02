<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseFreightQuotes extends Model
{
    use HasFactory;

    protected $table = 'response_freight_quotes'; 

     protected $fillable = [
        'validity_date',
        'origin',
        'destination',
        'frequency',
        'service',
        'transit_time',
        'exchange_rate'
    ];


        // Evento que se ejecuta antes de guardar el modelo
    protected static function booted()
    {
        static::creating(function ($response) {
            // Si no tiene un número de respuesta, generarlo
            if (empty($response->nro_response)) {
                $response->nro_response = $response->generateNroResponse();
            }
        });
    }

    // Método para generar el número de operación
    public function generateNroResponse()
    {
        // Obtener el último registro
        $lastCode = self::latest('id')->first();
        $year = date('y');
        $prefix = 'RESPFLETE-';

        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            return $prefix . $year . '1';
        } else {
            // Extraer el número y aumentarlo

            $number = (int) substr($lastCode->nro_quote, 12);
            $number++;
            return $prefix . $year . $number;
        }
    }





}
