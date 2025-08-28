<?php

namespace App\Http\Controllers;

use App\Models\CommercialQuote;
use App\Models\QuoteSentClientConcept;
use App\Models\QuotesSentClient;
use App\Services\CommercialQuoteService;
use App\Services\CustomService;
use App\Services\FreightService;
use App\Services\TransportService;
use Illuminate\Http\Request;

class CommercialQuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $freightService;
    protected $customService;
    protected $transportService;
    protected $commercialQuoteService;

    public function __construct(CommercialQuoteService $commercialQuoteService, FreightService $freightService, TransportService $transportService, CustomService $customService)
    {
        $this->commercialQuoteService = $commercialQuoteService;
        $this->freightService = $freightService;
        $this->transportService = $transportService;
        $this->customService = $customService;
    }

    public function index()
    {
        $compact = $this->commercialQuoteService->getQuotes();

        $heads = [
            '#',
            'N° de cotizacion',
            'Origen',
            'Destino',
            'Cliente',
            'Tipo de embarque',
            'Asesor Comercial',
            'Consolidado',
            'Fecha',
            'Estado',
            'Acciones'
        ];



        return view('commercial_quote/list-commercial-quote', array_merge($compact, compact('heads')));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $compact = $this->commercialQuoteService->createCommercialQuote();

        return view("commercial_quote/register-commercial-quote", $compact);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $commercialQuote = $this->commercialQuoteService->storeCommercialQuote($request);

        return redirect('commercial/quote/' . $commercialQuote->id . '/detail');
    }


    public function completeData(Request $request)
    {

       $respuesta =  $this->commercialQuoteService->completeDataCommercialQuote($request);

       return $respuesta;
    }


    public function getTemplateDetailCommercialQuote($id)
    {

        $compact = $this->commercialQuoteService->getTemplateDetailCommercialQuote($id);

        return view('commercial_quote/detail-commercial-quote', $compact);
    }


    public function getTemplateQuoteCommercialQuote(string $id)
    {
        $compact = $this->commercialQuoteService->getTemplateQuoteCommercialQuote($id);

        return view('commercial_quote/detail-commercial-quote', $compact);
    }


    public function getTemplateDocmentCommercialQuote(string $id)
    {
        $compact = $this->commercialQuoteService->getTemplateDocmentCommercialQuote($id);

        return view('commercial_quote/detail-commercial-quote', $compact);
    }


    public function editCommercialQuoteService($service, $id)
    {
        switch ($service) {
            case 'flete':
                # code...

                $data = $this->freightService->editFreight($id);

                return view('freight/edit-freight', $data);

                break;

            case 'aduanas':
                # code...

                $data = $this->customService->editCustom($id);

                return view('custom/edit-custom', $data);

                break;

            case 'transporte':
                # code...

                $data = $this->transportService->editTransport($id);
                return view('transport/edit-transport', $data);

                break;

            default:
                # code...
                break;
        }

        return $service;
    }



    public function createQuote(String $nro_quote_commercial, Request $request)
    {

        $this->commercialQuoteService->createQuote($nro_quote_commercial, $request);

        return response()->json([
            'message' => "Cotizacion creada"
        ], 200);
    }


    public function handleActionCommercialQuote(string $action, string $id)
    {

        $commercialQuote = $this->commercialQuoteService->handleActionCommercialQuote($action, $id);

        // Condicionar el mensaje de éxito o error según la acción
        if ($action === 'accept') {
            $message = 'La cotización fue aceptada.';
            $messageType = 'success'; // Tipo de mensaje para acción aceptada
        } elseif ($action === 'decline') {
            $message = 'La cotización fue rechazada.';
            $messageType = 'error'; // Tipo de mensaje para acción rechazada
        } else {
            $message = 'Acción no válida.';
            $messageType = 'error'; // Si la acción no es válida, es un error
        }

        return redirect('commercial/quote/' . $commercialQuote->id . '/detail')->with([
            $messageType => $message,
            'show_client_trace_modal' => true,
            'quote_id' => $commercialQuote->id,
            'type_action' => $action
        ]);
    }


    public function updateDate(Request $request, string $id)
    {
        $commercialQuote = $this->commercialQuoteService->updateDate($request, $id);

        return redirect('commercial/quote/' . $commercialQuote->id . '/detail');
    }


    /**
     * Actualiza los costos netos de los conceptos de transporte (Área de Transporte).
     */
    public function updateTransportCosts(Request $request, $quoteTransportId)
    {
        $this->commercialQuoteService->updateTransportCosts($request, $quoteTransportId);

        return redirect()->back()->with('success', 'Costos netos actualizados por el área de transporte.');
    }


    public function updateCommercialMargins(Request $request, $quoteTransportId)
    {
        $this->commercialQuoteService->updateCommercialMargins($request, $quoteTransportId);
    }


    public function storeClientTrace(Request $request)
    {
        $quote = $this->commercialQuoteService->storeClientTrace($request);
        return redirect()
            ->route('commercial.quote.detail', $quote->id)
            ->with('success', 'La decisión del cliente fue registrada correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function showCustomerForName(string $name)
    {
        $customer = $this->commercialQuoteService->showCustomerForName($name);
        return response()->json($customer);
    }


    public function QuoteSentClient(Request $request)
    {
        $commercialQuote = CommercialQuote::findOrFail($request->commercialQuoteId);

        $existingQuote = $commercialQuote->quotesSentClients()->where('status', '!=', 'Anulado')->first();

        if ($existingQuote) {
            return redirect()->back()->with("error", "Debe anular la cotización {$existingQuote->nro_quote_commercial} antes de generar uno nuevo.");
        }

        $totalQuoteSentClient = 0;

        $quoteSentClient = QuotesSentClient::create([

            'origin' => $commercialQuote->origin,
            'destination' => $commercialQuote->destination,
            'customer_company_name' => $commercialQuote->customer_company_name,
            'load_value' => $commercialQuote->load_value,
            'id_personal' => $commercialQuote->id_personal,
            'id_type_shipment' => $commercialQuote->id_type_shipment,
            'id_regime' => $commercialQuote->id_regime,
            'id_incoterms' => $commercialQuote->id_incoterms,
            'id_type_load' => $commercialQuote->id_type_load,
            'id_customer' => $commercialQuote->id_customer,
            'id_supplier' => $commercialQuote->id_supplier,
            'lcl_fcl' => $commercialQuote->lcl_fcl,
            'is_consolidated' => $commercialQuote->is_consolidated,
            'commodity' => $commercialQuote->commodity,
            'nro_package' => $commercialQuote->nro_package,
            'id_packaging_type' => $commercialQuote->id_packaging_type,
            'kilograms' => $commercialQuote->kilograms,
            'volumen' => $commercialQuote->volumen,
            'pounds' => $commercialQuote->pounds,
            'kilogram_volumen' => $commercialQuote->kilogram_volumen,
            'tons' => $commercialQuote->tons,
            'measures' => $commercialQuote->measures,
            'cif_value' => $commercialQuote->cif_value,
            'customs_taxes' => $commercialQuote->custom ? $commercialQuote->custom->customs_taxes : null,
            'customs_perception' => $commercialQuote->custom ? $commercialQuote->custom->customs_perception : null,
            'valid_date' => $commercialQuote->valid_date,
            'commercial_quote_id' => $commercialQuote->id,
        ]);


        $commercialQuote->update([
            'state' => 'Aceptado'
        ]);


        if ($commercialQuote->freight) {
            $commercialQuote->freight->update(['state' => 'Aceptado']);

            /* Total del flete */

            $quoteSentClient->update([
                'total_freight' => $commercialQuote->freight->value_sale
            ]);

            /* Conceptos para quote_sent_client */

            $concepts = $commercialQuote->freight->concepts;
            foreach ($concepts as $concept) {

                $quoteSentClient->concepts()->attach(
                    $concept->id,  // El ID del concepto
                    ['concept_value' => $concept->pivot->value_concept, 'service_type' => 'Flete']
                );
            }

            $totalQuoteSentClient += $commercialQuote->freight->value_sale;
        }

        if ($commercialQuote->transport) {
            $commercialQuote->transport->update(['state' => 'Aceptado']);

            /* Total del transporte */

            $quoteSentClient->update([
                'total_transport' => $commercialQuote->transport->value_sale
            ]);

            $concepts = $commercialQuote->transport->concepts;

            foreach ($concepts as $concept) {

                $quoteSentClient->concepts()->attach(
                    $concept->id,  // El ID del concepto
                    ['concept_value' => $concept->pivot->value_concept, 'service_type' => 'Transporte']
                );
            }

            $totalQuoteSentClient += $commercialQuote->transport->value_sale;
        }

        if ($commercialQuote->custom) {
            $commercialQuote->custom->update(['state' => 'Aceptado']);
            /* Total de la aduana */
            $quoteSentClient->update([
                'total_custom' => $commercialQuote->custom->sub_total_value_sale
            ]);

            $concepts = $commercialQuote->custom->concepts;
            foreach ($concepts as $concept) {

                $quoteSentClient->concepts()->attach(
                    $concept->id,  // El ID del concepto
                    ['concept_value' => $concept->pivot->value_sale, 'service_type' => 'Aduanas']
                );
            }

            $totalQuoteSentClient += $commercialQuote->custom->value_sale;
        }


        $quoteSentClient->update([
            'total_quote_sent_client' => $totalQuoteSentClient
        ]);



        return redirect()->back()->with('quoteSentClient', $quoteSentClient->nro_quote_commercial);
    }


    public function generateRoPdf($commercialQuote)
    {
        $this->commercialQuoteService->generateRoPdf($commercialQuote);
    }
}
