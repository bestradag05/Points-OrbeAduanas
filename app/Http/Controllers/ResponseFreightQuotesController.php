<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use App\Models\QuoteFreight;
use App\Models\ResponseFreightQuotes;
use App\Models\TypeInsurance;
use App\Services\FreightService;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResponseFreightQuotesController extends Controller
{


    protected $freightService;

    public function __construct(FreightService $freightService)
    {
        $this->freightService = $freightService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, String $id)
    {
        $this->validateForm($request, null);

        $concepts = json_decode($request->input('concepts'), true);
        $commissions = json_decode($request->input('commissions'), true);

        $quoteFreight = QuoteFreight::findOrFail($id)->first();


        $fecha = Carbon::createFromFormat('d/m/Y', $request->validity_date)->format('Y-m-d');

        $response = ResponseFreightQuotes::create([
            'nro_response' => $request->nro_response,
            'validity_date' => $fecha,
            'id_supplier' => $request->id_supplier,
            'airline' => $request->airline,
            'shipping_company' => $request->shipping_company,
            'origin' => $quoteFreight->origin,
            'destination' => $quoteFreight->destination,
            'frequency' => $request->frequency,
            'service' => $request->service,
            'transit_time' => $request->transit_time,
            'free_days' => $request->free_days,
            'exchange_rate' => $request->exchange_rate,
            'total' => $request->total_response_concept_freight,
            'id_quote_freight' => $id
        ]);


        foreach ($concepts as $item) {
            $concept = $item['concept'];
            $currency = $item['currency'];

            $response->concepts()->attach($concept['id'], [
                'unit_cost' => $item['unit_cost'],
                'currency_id' => $currency['id'],
                'fixed_miltiplyable_cost' => $item['fixed_miltiplyable_cost'],
                'observations' => $item['observations'],
                'final_cost' => $item['final_cost'],
            ]);
        }


        foreach ($commissions as $item) {
            $response->commissions()->attach($item['commission_id'], [
                'amount' => $item['final_cost'],
            ]);
        }

        return redirect()->route('quote.freight.show', $id)
            ->with('success', 'Respuesta registrada con éxito.');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $response = ResponseFreightQuotes::with('quote.commercial_quote')->findOrFail($id);


          //Generar el pdf de respuesta: 

        $pdf = FacadePdf::loadView('freight.pdf.responseFreight', compact('response'));

         return $pdf->stream('Respuesta.pdf'); 
    }


    public function accept($id)
    {
        $response = ResponseFreightQuotes::findOrFail($id);
        $response->status = 'Aceptado';
        $response->save();

        return redirect()->back()->with('success', 'Respuesta aceptada correctamente.');
    }

    public function generate($id)
    {
        $response = ResponseFreightQuotes::findOrFail($id);
        $compact = $this->freightService->createFreight($response->quote->id);

        return view('freight/register-freight', $compact);
    }

    public function reject($id)
    {
        $response = ResponseFreightQuotes::findOrFail($id);
        $response->status = 'Rechazada';
        $response->save();

        return redirect()->back()->with('success', 'Respuesta rechazada correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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

        return Validator::make($request->all(), [
            'nro_response' => 'required|date|unique:response_freight_quotes,nro_response,' . $id,
            'id_supplier' => 'required|number',
            'validity_date' => 'required|date',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'frequency' => 'required|string',
            'service' => 'required|string',
            'transit_time' => 'required|string',
            'exchange_rate' => 'nullable|number'

        ]);
    }
}
