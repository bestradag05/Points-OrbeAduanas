<?php

namespace App\Models;

use App\Traits\HasJustifications;
use App\Traits\HasTrace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotesSentClient extends Model
{
    use HasFactory;
    use HasTrace;
    use HasJustifications;

    protected $fillable = [
        'nro_quote_commercial',
        'origin',
        'destination',
        'customer_company_name',
        'load_value',
        'id_personal',
        'id_type_shipment',
        'id_regime',
        'id_incoterms',
        'id_type_load',
        'id_customer',
        'id_supplier',
        'lcl_fcl',
        'is_consolidated',
        'commodity',
        'nro_package',
        'id_packaging_type',
        'kilograms',
        'volumen',
        'pounds',
        'kilogram_volumen',
        'tons',
        'measures',
        'cif_value',
        'customs_taxes',
        'customs_perception',
        'valid_until',
        'total_freight',
        'total_transport',
        'total_custom',
        'total_quote_sent_client',
        'commercial_quote_id',
        'status'
    ];

    protected $casts = [
        'valid_until' => 'date', // Convierte 'valid_until' en un objeto Carbon
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


    public function originState()
    {
        return $this->belongsTo(StateCountry::class, 'origin');
    }

    public function destinationState()
    {
        return $this->belongsTo(StateCountry::class, 'destination');
    }
    public function type_shipment()
    {
        return $this->belongsTo(TypeShipment::class, 'id_type_shipment', 'id');
    }
    public function incoterm()
    {
        return $this->belongsTo(Incoterms::class, 'id_incoterms', 'id');
    }

    public function type_load()
    {
        return $this->belongsTo(TypeLoad::class, 'id_type_load', 'id');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id');
    }


    public function regime()
    {
        return $this->belongsTo(Regime::class, 'id_regime', 'id');
    }

    public function containers()
    {
        return $this->belongsTo(Container::class, 'id_containers');
    }


    public function containersFcl()
    {
        return $this->belongsToMany(Container::class, 'commercial_quote_containers', 'commercial_quote_id', 'containers_id')
            ->withPivot('container_quantity', 'commodity', 'nro_package', 'id_packaging_type', 'kilograms', 'volumen', 'measures')
            ->withTimestamps();
    }

    public function commercialQuoteContainers()
    {
        return $this->hasMany(CommercialQuoteContainer::class, 'commercial_quote_id');
    }

    public function typeService()
    {
        return $this->belongsToMany(TypeService::class, 'commercialquote_typeservice', 'id_commercial_quote', 'id_type_service');
    }


    public function commercialQuote()
    {
        return $this->belongsTo(CommercialQuote::class, 'commercial_quote_id');
    }

    public function justifications()
    {
        return $this->morphMany(QuoteJustifications::class, 'quotable');  // Polymorphic inverse relation
    }

    public function traces()
    {
        return $this->morphMany(Trace::class, 'traceable');
    }

    public function concepts()
    {
        return $this->belongsToMany(Concept::class, 'quote_sent_client_concepts', 'quote_sent_client_id', 'concept_id')
            ->withPivot(['concept_value', 'service_type']);
    }
}
