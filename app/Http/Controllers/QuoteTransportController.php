<?php

namespace App\Http\Controllers;

use App\Models\Routing;
use Illuminate\Http\Request;

class QuoteTransportController extends Controller
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
        //
        return view('transport.quote.register-quote')->with('showModal', true);
    }


    public function searchRouting($nro_operation)
    {

        $routing = Routing::where('nro_operation', $nro_operation)
        ->with('customer','type_load')
        ->get();

        if ($routing->isEmpty()) {
            // Retornar una respuesta de error JSON
            return response()->json([
                'success' => false,
                'message' => 'No se encontro ninguna operación con ese numero.'
            ], 404); // Código de estado 404 (No encontrado)
        }

        // Retornar los datos encontrados
        return response()->json([
            'success' => true,
            'data' => $routing
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $this->validateForm($request, null);

        return "ok";

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
            'nro_operation' => 'required|string|unique:quote_transport,nro_operation,' . $id,
            'customer' => 'required|string',
            'pick_up_lcl' => 'required_if:lcl_fcl,LCL',
            'pick_up_fcl' => 'required_if:lcl_fcl,FCL',
            'delivery' => 'required|string',
            'container_return' => 'required_if:lcl_fcl,FCL',
            'contact_name' => 'required|string',
            'contract_phone' => 'required|string',
            'max_attention_hour' => 'required|string',
            'gang' => 'required|string',
            'customer_detail' => 'nullable',
            'load_type' => 'required|string',
            'commodity' => 'required|string',
            'guard' => 'required_if:lcl_fcl,FCL',
            'container_type' => 'required_if:lcl_fcl,FCL',
            'ton_kilogram' => 'required_if:lcl_fcl,FCL',
            'packaging_type' => 'required|string',
            'stackable' => 'required|string',
            'cubage_kgv' => 'required_if:lcl_fcl,LCL',
            'total_weight' => 'required_if:lcl_fcl,LCL',
            'packages' => 'required|string',
            'cargo_detail' => 'nullable',
            'measures' => 'required',
            'lcl_fcl' => 'required',
        ]);

        
    }


}
