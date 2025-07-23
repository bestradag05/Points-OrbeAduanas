<?php

namespace App\Services;

use App\Models\AdditionalPoints;
use App\Models\CommercialQuote;
use App\Models\Concept;
use App\Models\ConceptsTransport;
use App\Models\QuoteTransport;
use App\Models\ResponseTransportQuote;
use App\Models\Supplier;
use App\Models\Transport;
use App\Models\TypeInsurance;
use App\Models\TypeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransportService
{



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
            $transports = Transport::with('quoteTransport')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $transports = Transport::whereHas('routing', function ($query) use ($personalId) {
                $query->where('id_personal', $personalId);
            })->with('quoteTransport')->get();
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




    public function createTransport($quoteId)
    {
        $quote = QuoteTransport::findOrFail($quoteId);
        $commercial_quote = $quote->commercial_quote;
        $acceptedResponse = $quote
            ->responses()
            ->where('status', 'Aceptado')
            ->with(['conceptResponseTransports.concept'])
            ->first();
        $type_insurace = TypeInsurance::all();
        $concepts = Concept::all();
        $conceptsTransport = [];

        $conceptsTransport = $acceptedResponse
            ->conceptResponseTransports
            ->map(function ($pivot) {
                return [
                    'concepts_id'         => $pivot->concepts_id,
                    'concept'             => ['name' => $pivot->concept->name],
                    'pivot'               => ['net_amount_response' => $pivot->net_amount_response],
                ];
            });

        return compact('quote', 'acceptedResponse', 'commercial_quote', 'concepts', 'conceptsTransport');
    }

    /*  $quote = QuoteTransport::findOrFail($quoteId);
        $acceptedResponse = $quote->responses()->where('status', 'Aceptado')->first();
        $commercial_quote = $quote->commercial_quote;
        $type_insurace = TypeInsurance::all();
        $concepts = Concept::all();
        $conceptsTransport = [];


        $conceptsTransport = $concepts->map(function ($concept) use ($quote, $commercial_quote) {
            $data = collect($concept)->only(['id', 'name']); // Atributos que deseas conservar

            if ($commercial_quote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Transporte') {
                if ($concept->name === 'TRANSPORTE') {
                    return $data->merge(['cost' => $quote->cost_transport]);
                }
            }
            return null; // Si no cumple ninguna condición, no lo incluye
        })->filter()->values(); // Filtra los `null` y reindexa la colecció


        return compact('quote', 'type_insurace', 'concepts', 'conceptsTransport', 'commercial_quote', 'acceptedResponse');
    }
 */
    public function storeTransport($request)
    {

        $concepts  = json_decode($request->concepts);
        $quoteId = $request->input('quote_transport_id');
        $quote = QuoteTransport::findOrFail($quoteId);
        $response = $quote->responses()->where('status', 'Aceptado')->with('conceptResponseTransports')->first();

        // 1. Creamos el transporte sin total aún (lo pondremos luego)
        $transport = $this->createOrUpdateTransport($request);

        $this->syncTransportConcepts($transport, $concepts, $response);


        return $transport;
    }

    public function editTransport(string $id)
    {


        $transport = Transport::with('concepts')->findOrFail($id);
        $formMode = 'edit';

        $commercial_quote = $transport->commercial_quote;


        $quote = $transport->quoteTransport()->where('state', 'Pendiente')->first();
        $concepts = Concept::all();


        // Obtenemos la respuesta aceptada para esa cotización de transporte
        $acceptedResponse  = ResponseTransportQuote::where('quote_transport_id', $quote->id)
            ->where('status', 'Aceptado')
            ->first();

        return compact('transport', 'commercial_quote', 'quote', 'concepts', 'formMode', 'acceptedResponse');
    }

        /*    $conceptsTransport = $concepts->map(function ($concept) use ($quote, $commercial_quote) {
            $data = collect($concept)->only(['id', 'name']); // Atributos que deseas conservar

            if ($commercial_quote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Transporte') {
                if ($concept->name === 'TRANSPORTE') {
                    return $data->merge(['cost' => $quote->cost_transport]);
                }
            }

            return null; // Si no cumple ninguna condición, no lo incluye
        })->filter()->values(); // Filtra los `null` y reindexa la colección */


    public function updateTransport($request, $id)
    {

        $concepts = json_decode($request->concepts);

        $transport = $this->createOrUpdateTransport($request, $id);

        $quoteId = $request->input('quote_transport_id');
        $quote = QuoteTransport::findOrFail($quoteId);

        $response = $quote->responses()->where('status', 'Aceptado')->with('conceptResponseTransports')->first();

        $this->syncTransportConcepts($transport, $concepts, $response);

        return $transport;
    }


    private function createOrUpdateTransport(Request $request, $id = null)
    {
        /* $transport = $id ? Transport::findOrFail($id) : new Transport(); */

        // Buscar transporte existente por nro_quote_commercial
        $transport = Transport::where('nro_quote_commercial', $request->nro_quote_commercial)->first();

        // Si no existe, se crea uno nuevo
        if (! $transport) {
            $transport = new Transport();
        }

        $commercial = CommercialQuote::where('nro_quote_commercial', $request->nro_quote_commercial)->first();

        $typeService = TypeService::where('name', 'Transporte')->first();

        if ($commercial && $typeService) {
            if ($id) {
                // Si es una edición, aseguramos que la relación exista sin duplicarse
                $commercial->typeService()->syncWithoutDetaching([$typeService->id]);
            } else {
                // Si es una creación, simplemente la agregamos
                $commercial->typeService()->attach($typeService->id);
            }
        }

        $dateRegisterFormat = Carbon::createFromFormat('d/m/Y', $request->withdrawal_date)->toDateString();

        $transport->fill([
            'origin' => $request->pick_up,
            'destination' => $request->delivery,
            'withdrawal_date' => $dateRegisterFormat,
            'quote_transport_id' => $request->quote_transport_id,
            'nro_quote_commercial' => $request->nro_quote_commercial,
            'accepted_answer_value'  => $request->total_usd,
            'total_answer_utility'  => $request->total_prices_usd,
            'value_utility'          => $request->value_utility,
            'total_transport_value'    => $request->input('total_transport_value'),
            'profit'                   => $request->input('profit'),
            'state' => 'Pendiente'
        ]);

        $transport->save();

        return $transport;
    }


    private function syncTransportConcepts($transport, $concepts, $response): void

    {
        // Eliminar los conceptos previos si estamos actualizando, pero antes 
        $conceptsTransport = ConceptsTransport::where('transport_id', $transport->id)->get(); // cuando eliminamos el concepto se elimina el additional_point relacionado en cascada

        if ($conceptsTransport) {
            foreach ($conceptsTransport as $concept) {
                $concept->additional_point()->delete();
                $concept->forceDelete(); // Esto elimina el ConceptTransport definitivamente
            }
        }

        $totalTransport = 0;

        // Relacionamos los nuevos conceptos con el tranporte
        foreach ($concepts as $concept) {
            

            // 1 Obtener el net_amount desde concepts_response_transport
            $net = optional(
                $response->conceptResponseTransports->firstWhere('concepts_id', $concept->id)
            )->net_amount;

            // Si no hay valor original, tomamos el value ingresado en la vista
            if ($net === null) {
                $net = $this->parseDouble($concept->value); // ← usa el valor del formulario
            }



            $concept_total = $net; // total de este concepto
            $base_sin_igv = $concept_total / 1.18;
            $igv = $concept_total - $base_sin_igv;
            $subtotal = $concept_total - $igv;

            $totalTransport += $concept_total;


            // 3 Guardar todo en concepts_transport
            $conceptsTransport = ConceptsTransport::create([
                'concepts_id' => $concept->id,
                'transport_id' => $transport->id,
                'net_amount_response' => $net,
                'subtotal' => $subtotal,
                'igv' => $igv,
                'total' => $concept_total,
                'additional_points' => $concept->pa ?? 0,
            ]);
        }
    }


    public function add_aditionals_point($conceptTransport, $net_amount = null, $igv = null, $total = null)
    {

        $additional_point = AdditionalPoints::create([
            'type_of_service' => $conceptTransport->concepts->name,
            'amount' => $net_amount,
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
