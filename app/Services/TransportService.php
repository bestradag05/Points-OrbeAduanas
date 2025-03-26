<?php

namespace App\Services;

use App\Models\Concepts;
use App\Models\Supplier;
use App\Models\Transport;

class TransportService {



    public function editTransport(string $id){

        $transport = Transport::with('concepts.concept_transport.additional_point')->find($id);
        $commercial_quote = $transport->commercial_quote;


        $quote = $transport->quoteTransports()->where('state', 'Aceptado')->first();
        $concepts = Concepts::all();


        $conceptsTransport = $concepts->map(function ($concept) use ($quote, $commercial_quote) {
            $data = collect($concept)->only(['id', 'name']); // Atributos que deseas conservar

            if ($commercial_quote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Transporte') {
                if ($concept->name === 'TRANSPORTE') {
                    return $data->merge(['cost' => $quote->cost_transport]);
                }
            }

            return null; // Si no cumple ninguna condición, no lo incluye
        })->filter()->values(); // Filtra los `null` y reindexa la colección


        /* dd($conceptsTransport); */
        
       
        return compact('transport', 'commercial_quote', 'quote', 'concepts', 'conceptsTransport');

    }



}