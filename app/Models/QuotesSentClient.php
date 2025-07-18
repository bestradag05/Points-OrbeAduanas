<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotesSentClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nro_quote_commercial',
        'commercial_quote_id',
        'status'
    ];


    protected static function booted()
    {
        static::creating(function ($quoteSentClient) {
            // Si no tiene un número de operación, generarlo
            if (empty($quoteSentClient->nro_quote_commercial)) {
                // Acceder al CommercialQuote relacionado para obtener la información
                $commercialQuote = $quoteSentClient->commercialQuote; // Obtiene la relación

                // Obtener el código del régimen y del tipo de envío desde CommercialQuote
                $operationCode = $commercialQuote->regime->code; // "10" para Importación
                $shipmentCode = $commercialQuote->type_shipment->code; // "119" para Marítimo
                $year = date('y'); // Últimos dos dígitos del año actual

                // Obtener el último número correlativo del mismo año
                $lastCode = QuotesSentClient::whereYear('created_at', date('Y'))
                    ->latest('id')
                    ->first();

                // Si no hay registros, empezar desde 0001
                $nextCorrelative = $lastCode ? (int) substr($lastCode->nro_quote_commercial, -4) + 1 : 1;

                // Asegurarse de que el número correlativo tenga 4 dígitos
                $formattedCorrelative = str_pad($nextCorrelative, 4, '0', STR_PAD_LEFT);

                // Generar el código de cotización
                $quoteSentClient->nro_quote_commercial = "COTI-{$operationCode}{$shipmentCode}-{$formattedCorrelative}-{$year}";
            }
        });
    }

    public function commercialQuote()
    {
        return $this->belongsTo(CommercialQuote::class, 'commercial_quote_id');
    }
}
