<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
use App\Models\Concepts;
use App\Models\ConceptsTransport;
use App\Models\QuoteTransport;
use App\Models\Supplier;
use App\Models\Transport;
use App\Models\TypeInsurance;
use App\Models\ResponseTransportQuote;
use App\Services\TransportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransportController extends Controller
{



    protected $trasnportService;

    public function __construct(TransportService $trasnportService)
    {
        $this->trasnportService = $trasnportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listar transportes

        $compact = $this->trasnportService->index();

        return view("transport/list-transport", compact("transports", "heads"));
    }



    public function getTransportPending()
    {

        $compact = $this->trasnportService->getTransportPending();


        return view("transport/pending-list-transport", $compact);
    }


    public function getTransportPersonal()
    {
        $compact = $this->trasnportService->getTransportPersonal();

        return view("transport/list-transport-personal", $compact);
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

        $response = $quote->responseTransportQuotes()
            ->where('status', 'Aceptado')
            ->with('conceptResponses.concept')
            ->firstOrFail();

        return view('transport.register-transport', compact('quote', 'response'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*         $transport = $this->trasnportService->storeTransport($request);

        return redirect('/commercial/quote/' . $transport->quote_transport_id . '/detail'); */

        // 1) Validamos los campos básicos de la tabla 'transport'
        $request->validate([
            'nro_operation_transport' => 'nullable|string|max:50',
            'nro_orden'              => 'nullable|string|max:50',
            'date_register'          => 'required|date',
            'invoice_number'         => 'nullable|string|max:50',
            'nro_dua'                => 'nullable|string|max:50',
            'origin'                 => 'required|string|max:255',
            'destination'            => 'required|string|max:255',
            'total_transport'        => 'nullable|numeric',
            'payment_state'          => ['required', Rule::in(['Pendiente', 'Pagado', 'Parcial'])],
            'payment_date'           => 'nullable|date',
            'weight'                 => 'nullable|numeric',
            'withdrawal_date'        => 'required|date',
            'state'                  => ['required', Rule::in(['Aceptado', 'Registrado', 'Completado'])],
            'nro_operation'          => 'nullable|string|max:50',
            'nro_quote_commercial'   => 'nullable|string|max:50',
            'id_supplier'            => 'required|integer|exists:suppliers,id',
            // El JSON de conceptos:
            'concepts'               => 'required|string',
        ]);

        // 2) Creamos el registro en 'transport'
        $transport = Transport::create([
            'nro_operation_transport' => $request->input('nro_operation_transport'),
            'nro_orden'               => $request->input('nro_orden'),
            'date_register'           => Carbon::parse($request->input('date_register'))->toDateString(),
            'invoice_number'          => $request->input('invoice_number'),
            'nro_dua'                 => $request->input('nro_dua'),
            'origin'                  => $request->input('origin'),
            'destination'             => $request->input('destination'),
            'total_transport'         => $request->input('total_transport'),   // opcional, puede calcularse luego
            'payment_state'           => $request->input('payment_state'),
            'payment_date'            => $request->input('payment_date')
                ? Carbon::parse($request->input('payment_date'))->toDateString()
                : null,
            'weight'                  => $request->input('weight'),
            'withdrawal_date'         => Carbon::parse($request->input('withdrawal_date'))->toDateString(),
            'state'                   => $request->input('state'),
            'nro_operation'           => $request->input('nro_operation'),
            'nro_quote_commercial'    => $request->input('nro_quote_commercial'),
            'id_supplier'             => $request->input('id_supplier'),
            'quote_transport_id'      => $quoteId,
        ]);

        // 3) Decodificamos el JSON que contiene cada concepto con sus valores
        //    El JSON viene de tu <input name="concepts" value="[...]"> generado por JavaScript.
        $jsonConcepts = $request->input('concepts');
        $conceptsArr = json_decode($jsonConcepts, true);

        // 4) Borramos filas previas, en caso de que sea una edición
        ConceptsTransport::where('transport_id', $transport->id)->delete();

        // 5) Por cada elemento del array, calculamos IGV y total, y guardamos en concepts_transport
        foreach ($conceptsArr as $item) {
            // a) Obtenemos valores desde el array
            $conceptId    = intval($item['id']);
            $neto         = floatval($item['value']); // valor original ya con comisión incluido si es TRANSPORTE
            $addedValue   = floatval($item['added']);
            $points       = intval($item['pa'] ?? 0);

            // b) Subtotal = neto + addedValue
            $subtotal = $neto + $addedValue;

            // c) IGV = 18% de subtotal
            $igv = round($subtotal * 0.18, 2);

            // d) Total fila = subtotal + igv
            $totalFila = round($subtotal + $igv, 2);

            ConceptsTransport::create([
                'transport_id'       => $transport->id,
                'concepts_id'        => $conceptId,
                'added_value'        => $addedValue,
                'igv'                => $igv,
                'total'              => $totalFila,
                'additional_points'  => $points,
            ]);
        }

        // 6) (Opcional) Actualizar algún campo en la cotización para marcar “Transporte Registrado”
        //    Por ejemplo:
        //    $quote = QuoteTransport::findOrFail($quoteId);
        //    $quote->update(['state' => 'Transporte Registrado']);

        // 7) Redirigir al índice de transportes (o la vista que corresponda)
        return redirect()
            ->route('transport.index')
            ->with('success', 'Transporte registrado correctamente.');
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

        $transport = $this->trasnportService->updateTransport($request, $id);

        return redirect('commercial/quote/' . $transport->commercial_quote->id . '/detail');
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
