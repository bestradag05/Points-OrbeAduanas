<?php

namespace App\Http\Controllers;

use App\Models\QuotesSentClient;
use App\Services\QuotesSentClientService;
use Illuminate\Http\Request;

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

    /**
     * Display the specified resource.
     */
    public function updateStateQuoteSentClient(QuotesSentClient $quotesSentClient)
    {
        //
        dd($quotesSentClient);
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
