<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
use App\Models\CommercialQuote;
use App\Models\ConceptFreight;
use App\Models\Concepts;
use App\Models\Freight;
use App\Models\Insurance;
use App\Models\QuoteFreight;
use App\Models\TypeInsurance;
use App\Services\FreightService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class FreightController extends Controller
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
        $compact = $this->freightService->index();

        return view("freight/list-freight", $compact);
    }


    public function getFreightPending()
    {

        $compact = $this->freightService->getFreightPending();

        return view("freight/pending-list-freight", $compact);
    }

    public function getFreightPersonal()
    {

       $compact = $this->freightService->getFreightPersonal();

        return view("freight/list-freight-personal", $compact);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    public function createFreight($quoteId)
    {

        $compact = $this->freightService->createFreight($quoteId);

        return view('freight.register-freight', $compact);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $freight = $this->freightService->storeFreight($request);

        return redirect('commercial/quote/' . $freight->commercial_quote->id . '/detail');
    }


    public function generateRouting(Request $request)
    {
        $compact = $this->freightService->generateRoutingOrder($request);
        return view("freight/detail-freight", $compact);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $compact = $this->freightService->showFreight($id);

      return view("freight/detail-freight", $compact);
    }



    public function getTemplateGeneratePointFreight(string $id)
    {
        $compact = $this->freightService->getTemplateGeneratePointFreight($id);
       
       return $compact;
    }

    public function updatePointFreight(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $this->freightService->updatePointFreight($request, $id);

        return redirect('freight');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */ 
    public function update(Request $request, string $id)
    {
        $freight = $this->freightService->updateFreight($request, $id);
        
        return redirect('commercial/quote/' . $freight->commercial_quote->id . '/detail');
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
            'roi' => 'required|string|unique:freight,roi,' . $id
        ]);
    }



    
}
