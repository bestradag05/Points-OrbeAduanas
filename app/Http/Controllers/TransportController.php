<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
use App\Models\Concepts;
use App\Models\ConceptTransport;
use App\Models\QuoteTransport;
use App\Models\Supplier;
use App\Models\Transport;
use App\Models\TypeInsurance;
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

        $compact = $this->trasnportService->createTransport($quoteId);


        return view('transport.register-transport', $compact);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transport = $this->trasnportService->storeTransport($request);

        return redirect('/commercial/quote/' . $transport->id_quote_transport . '/detail');
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
