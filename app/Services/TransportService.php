<?php

namespace App\Services;

use App\Models\AdditionalPoints;
use App\Models\Concepts;
use App\Models\ConceptTransport;
use App\Models\QuoteTransport;
use App\Models\Supplier;
use App\Models\Transport;
use App\Models\TypeInsurance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransportService {



    public function index()
    {
        // Listar transportes

        $transports = Transport::all();

        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Origen',
            'Destino',
            'Estado',
            'Acciones'
        ];

        return  compact("transports", "heads");
    }



    public function getTransportPending()
    {

        //Listar aduanas

        $transports = Transport::where('state', 'Pendiente')->get();

        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Origen',
            'Destino',
            'Estado',
            'Acciones'
        ];


        return compact("transports", "heads");
    }


    public function getTransportPersonal()
    {
        $personalId = Auth::user()->personal->id;

        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los routing
            $transports = Transport::with('quoteTransports')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $transports = Transport::whereHas('routing', function ($query) use ($personalId) {
                $query->where('id_personal', $personalId);
            })->with('quoteTransports')->get();
        }

        $heads = [
            '#',
            'N° De transporte',
            'N° Operacion',
            'Origen',
            'Destino',
            'Total de transporte',
            'Fecha de retiro',
            'Estado',
        ];

        return  compact("transports", "heads");
    }




    public function createTransport($quoteId){
      
        $quote = QuoteTransport::findOrFail($quoteId);
        $commercial_quote = $quote->commercial_quote;
        $type_insurace = TypeInsurance::all();
        $concepts = Concepts::all();
        $conceptsTransport = [];

        
        $conceptsTransport = $concepts->map(function ($concept) use ($quote, $commercial_quote) {
            $data = collect($concept)->only(['id', 'name']); // Atributos que deseas conservar

            if ($commercial_quote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Transporte') {
                if ($concept->name === 'TRANSPORTE') {
                    return $data->merge(['cost' => $quote->cost_transport]);
                }
            }

            return null; // Si no cumple ninguna condición, no lo incluye
        })->filter()->values(); // Filtra los `null` y reindexa la colección


        return compact('quote', 'type_insurace', 'concepts', 'conceptsTransport', 'commercial_quote');


    }

    public function storeTransport($request){

        $concepts  = json_decode($request->concepts);

        $transport = $this->createOrUpdateTransport($request);

        $this->syncTransportConcepts($transport, $concepts);


        return $transport;

    }

    public function editTransport(string $id){
        

        $transport = Transport::with('concepts')->find($id);
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


       
        return compact('transport', 'commercial_quote', 'quote', 'concepts', 'conceptsTransport');

    }


    public function updateTransport($request, $id)
    {

        $concepts = json_decode($request->concepts);

        $transport = $this->createOrUpdateTransport($request, $id);

        $this->syncTransportConcepts($transport, $concepts);

       return $transport;

    }


    private function createOrUpdateTransport(Request $request, $id = null)
    {
        $transport = $id ? Transport::findOrFail($id) : new Transport();


        $dateRegisterFormat = Carbon::createFromFormat('d/m/Y', $request->withdrawal_date)->toDateString();

        $transport->fill([
            'origin' => $request->pick_up,
            'destination' => $request->delivery,
            'total_transport' => $request->total,
            'withdrawal_date' => $dateRegisterFormat,
            'id_quote_transport' => $request->id_quote_transport,
            'nro_quote_commercial' => $request->nro_quote_commercial
        ]);

        $transport->save();


        return $transport;
    }


    private function syncTransportConcepts($transport, $concepts)
    {
        // Eliminar los conceptos previos si estamos actualizando, pero antes 
        $conceptsTransport = ConceptTransport::where('id_transport', $transport->id)->get(); // cuando eliminamos el concepto se elimina el additional_point relacionado en cascada

        if ($conceptsTransport) {
            foreach ($conceptsTransport as $concept) {
                $concept->additional_point()->delete();
                $concept->forceDelete(); // Esto elimina el ConceptTransport definitivamente
            }
        }

        // Relacionamos los nuevos conceptos con el flete
        foreach ($concepts as $concept) {

            $total = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);
            $net_amount = $total / 1.18;
            $igv = $total - $net_amount;

            $conceptTransport = ConceptTransport::create([
                'id_concepts' => $concept->id, // ID del concepto relacionado
                'id_transport' => $transport->id, // Clave foránea al modelo Freight
                'value_concept' => $this->parseDouble($concept->value),
                'added_value' => $this->parseDouble($concept->added),
                'net_amount' => $net_amount,
                'igv' => $igv,
                'total' => $total,
                'additional_points' => isset($concept->pa) ? $concept->pa : 0,
            ]);


            // Si hay puntos adicionales, ejecutamos la función
            if (isset($concept->pa)) {
                $ne_amount = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);
                $this->add_aditionals_point($conceptTransport, $ne_amount);
            }
        }
    }


    public function add_aditionals_point($conceptTransport,  $ne_amount = null, $igv = null, $total = null)
    {

        $additional_point = AdditionalPoints::create([
            'type_of_service' => $conceptTransport->concepts->name,
            'amount' => $ne_amount,
            'igv' => $igv,
            'total' => $total,
            'points' => $conceptTransport->additional_points,
            'id_additional_concept_service' => $conceptTransport->id,
            'model_additional_concept_service' => $conceptTransport::class,
            'additional_type' => ($conceptTransport::class === 'App\Models\ConceptFreight') ? 'AD-FLETE' : 'AD-ADUANA',
            'state' => 'Pendiente'
        ]);


        $conceptTransport->additional_point()->save($additional_point);
    }

    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
    }



}