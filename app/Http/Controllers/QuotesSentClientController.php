<?php

namespace App\Http\Controllers;

use App\Models\QuotesSentClient;
use App\Services\QuotesSentClientService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotesSentClientController extends Controller
{

    protected $quotesSentClientService;


    public function __construct(QuotesSentClientService $quotesSentClientService)
    {
        $this->quotesSentClientService = $quotesSentClientService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compact = $this->quotesSentClientService->getQuotesSetClient();

        $heads = [
            '#',
            'N° de cotizacion',
            'ReF ##',
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



        return view('quotes_sent_client/list-quote-sent-client', array_merge($compact, compact('heads')));
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
    public function store(Request $request)
    {
        //
    }



    public function generatePDF($id)
    {
        $quoteSentClient = QuotesSentClient::findOrFail($id);

        $personal = $quoteSentClient->personal;


        $freightConcepts = $quoteSentClient->concepts()->wherePivot('service_type', 'Flete')->get();
        $customConcepts = $quoteSentClient->concepts()->wherePivot('service_type', 'Aduanas')->get();
        $transportConcepts = $quoteSentClient->concepts()->wherePivot('service_type', 'Transporte')->get();




       $pdf = Pdf::loadView('commercial_quote.pdf.commercial_quote_pdf', compact('quoteSentClient', 'freightConcepts', 'customConcepts', 'transportConcepts', 'personal'));

        return $pdf->stream('Cotizacion Comercial.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function updateStateQuoteSentClient(String $id, String $action, Request $request)
    {

        $quotesSentClient = QuotesSentClient::findOrFail($id);
        $status = '';

        if (!$quotesSentClient) {
            return redirect()->back()->with('error', 'No se encontro la cotización enviada al cliente.');
        }

        $justification = $request->input('justification');

        switch ($action) {
            case 'accept':
                # code...
                $status = 'Aceptado';
                break;
            case 'decline':
                # code...
                $status = 'Rechazado';
                break;
            case 'expired':
                # code...
                $status = 'Caducado';
                break;
            case 'cancel':
                # code...
                $status = 'Anulado';
                break;

            default:
                # code...
                $status = 'Pendiente';
                break;
        }


        $quotesSentClient->update(['status' => $status]);


        if ($justification) {
            $quotesSentClient->registerJustification($quotesSentClient, $status, $justification);
        }

        return redirect()->back()->with('success', 'Se actualizo el estado de la cotizacion enviada al cliente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuotesSentClient $quotesSentClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuotesSentClient $quotesSentClient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuotesSentClient $quotesSentClient)
    {
        //
    }
}
