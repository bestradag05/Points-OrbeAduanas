<?php

namespace App\Http\Controllers;

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

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return view("transport/list-transport", compact("transports", "heads"));
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


        return view("transport/pending-list-transport", compact("transports", "heads"));
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

        return view("transport/list-transport-personal", compact("transports", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function createTransport($quoteId)
    {

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

                if ($quote->gang === 'SI' && $concept->name === 'CUADRILLA') {
                    return $data->merge(['cost' => $quote->cost_gang]);
                }

                if ($quote->guard === 'SI' && $concept->name === 'RESGUARDO') {
                    return $data->merge(['cost' => $quote->cost_guard]);
                }
            }

            return null; // Si no cumple ninguna condición, no lo incluye
        })->filter()->values(); // Filtra los `null` y reindexa la colección


        return view('transport.register-transport', compact('quote', 'type_insurace', 'concepts', 'conceptsTransport', 'commercial_quote'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Obtenemos el concepto llamado TRANSPORTE
        // Debido que en el reporte de transport solo colocan este concepto

        $concepts  = json_decode($request->concepts);

        $withdrawal_date = Carbon::createFromFormat('d/m/Y', $request->withdrawal_date)->format('Y-m-d');


        $transport = Transport::create([

            'origin' => $request->pick_up,
            'destination' => $request->delivery,
            'total_transport' => $request->total,
            'withdrawal_date' => $withdrawal_date,
            'id_quote_transport' => $request->id_quote_transport,
            'nro_quote_commercial' => $request->nro_quote_commercial,
            'state' => 'Pendiente'

        ]);


        //Relacionamos los conceptos que tendra este transporte


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


            //Verificamos si tienen puntos adicionales
            if (isset($concept->pa)) {
                $ne_amount = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);
                $this->add_aditionals_point($conceptTransport, $ne_amount,  $igv, $total);
            }
        }


        return redirect('/commercial/quote/'.$transport->id_quote_transport.'/detail');
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $transport = Transport::find($id);
        $suppliers = Supplier::all();

        return view('transport/edit-transport', compact('transport', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $transport = Transport::find($id);


        $dateRegisterFormat = Carbon::createFromFormat('d/m/Y', $request['date_register'])->toDateString();
        $request['date_register'] = $dateRegisterFormat;

        $paymentDateFormat = Carbon::createFromFormat('d/m/Y', $request['payment_date'])->toDateString();
        $request['payment_date'] = $paymentDateFormat;

        $request['state'] = "Generado";

        $transport->fill($request->all());
        $transport->save();

        return redirect('transport');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function validateForm($request, $id)
    {
        $request->validate([
            'date_register' => 'required|string',
            'invoice_number' => 'required|string|unique:transport,invoice_number,' . $id,
            'nro_orden' => 'required|string|unique:transport,nro_orden,' . $id,
            'nro_dua' => 'required|string|unique:transport,nro_dua,' . $id,
            'nro_dam' => 'string|unique:transport,nro_dam,' . $id,
            'id_supplier' => 'required',
            'payment_state' => 'required|string',
            'payment_date' => 'required|string',
            'weight' => 'required|string'
        ]);
    }
}
