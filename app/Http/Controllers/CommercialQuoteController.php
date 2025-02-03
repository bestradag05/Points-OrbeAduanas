<?php

namespace App\Http\Controllers;

use App\Models\CommercialQuote;
use App\Models\Incoterms;
use App\Models\Regime;
use App\Models\StateCountry;
use App\Models\TypeLoad;
use App\Models\TypeService;
use App\Models\TypeShipment;
use Illuminate\Http\Request;

class CommercialQuoteController extends Controller
{
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
        $nro_quote_commercial = $this->getNroQuoteCommercial();
        $stateCountrys = StateCountry::all()->load('country');
        $type_shipments = TypeShipment::all();
        $type_loads = TypeLoad::all();
        $regimes = Regime::all();
        $incoterms = Incoterms::all();
        $types_services = TypeService::all();

        return view("commercial_quote/register-commercial-quote", compact('stateCountrys', 'type_shipments', 'type_loads', 'regimes', 'incoterms', 'nro_quote_commercial', 'types_services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         /* dd($request->all()); */
         $this->validateForm($request, null);

        CommercialQuote::create([
            'nro_operation' => $request->nro_operation,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'load_value' => $this->parseDouble($request->load_value),
            'id_customer' => $request->id_customer,
            'id_supplier' => $request->id_supplier,
            'id_type_shipment' => $request->id_type_shipment,
            'id_regime' => $request->id_regime,
            'id_type_load' => $request->id_type_load,
            'id_incoterms' => $request->id_incoterms,
            'wr_loading' => $request->wr_loading,
            'commodity' => $request->commodity,
            'nro_package' => $request->nro_package,
            'packaging_type' => $request->packaging_type,
            'container_type' => $request->container_type,
            'pounds' => $request->pounds,
            'kilograms' => $request->kilograms != null ? $this->parseDouble($request->kilograms) : null,
            'volumen' => $request->volumen != null ?  $this->parseDouble($request->volumen) : null,
            'kilogram_volumen' => $request->kilogram_volumen != null ? $this->parseDouble($request->kilogram_volumen) : null,
            'tons' => $request->tons != null ?  $this->parseDouble($request->tons) : null,
            'lcl_fcl' => $request->lcl_fcl,
            'measures' => $request->value_measures,
            'hs_code' => $request->hs_code,
            'nro_operation' => $request->nro_operation,
            'observation' => $request->observation,
            'id_personal' => auth()->user()->personal->id,


        ]);


        return redirect('routing');
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

        /* dd($request->all()); */

        $request->validate([
            'nro_operation' => 'required|string|unique:routing,nro_operation,' . $id,
            'origin' => 'required|string',
            'destination' => 'required|string',
            'load_value' => 'required',
            'id_customer' => 'required',
            'id_supplier' => 'required',
            'id_type_shipment' => 'required',
            'id_regime' => 'required',
            'id_type_load' => 'required',
            'id_incoterms' => 'required',
            'wr_loading' => 'nullable',
            'commodity' => 'required',
            'nro_package' => 'required',
            'packaging_type' => 'required',
            'container_type' => 'required_if:lcl_fcl,FCL',
            'pounds' => 'nullable',
            'kilograms' => 'required_unless:lcl_fcl,FCL',
            'volumen' => 'required_if:type_shipment_name,Marítima',
            'kilogram_volumen' => 'required_if:type_shipment_name,Aérea',
            'tons' => 'required_if:lcl_fcl,FCL|max:8',
            'lcl_fcl' => 'required_if:type_shipment_name,Marítima',
            'hs_code' => 'nullable',
            'observation' => 'nullable'
        ]);
    }


    public function getNroQuoteCommercial()
    {
        $lastCode = CommercialQuote::latest('id')->first();
        $year = date('y');
        $prefix = 'COTI-';

        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            $codigo = $prefix . $year . '1';
        } else {
            // Extraer el número y aumentarlo
            $number = (int) substr($lastCode->nro_operation, 7);
            $number++;
            $codigo = $prefix . $year  . $number;
        }

        return $codigo;
    }
}
