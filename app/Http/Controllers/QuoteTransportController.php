<?php

namespace App\Http\Controllers;

use App\Models\QuoteTransport;
use App\Models\Routing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuoteTransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        // Obtener el ID del personal del usuario autenticado
        $personalId = Auth::user()->personal->id;

        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los routing
            $quotes = QuoteTransport::with('routing')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $quotes = QuoteTransport::with('routing')
                ->where('routing.id_personal', $personalId)
                ->get();
        }



        $heads = [
            '#',
            'Cliente',
            'Recojo',
            'Entrega',
            'Nombre del contacto',
            'Numero del contacto',
            'Hora maxima de atencion',
            'LCL / FCL',
            'Producto',
            'Cubicaje-KGV',
            'Tonelada-KG',
            'Peso Total',
            'Estado',
            'Acciones'
        ];

        return view('transport/quote/list_quote', compact('quotes', 'heads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $showModal = session('showModal', true);
        return view('transport.quote.register-quote')->with('showModal', $showModal);
    }


    public function searchRouting($nro_operation)
    {

        $routing = Routing::where('nro_operation', $nro_operation)
            ->with('customer', 'type_load')
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

        $validator = $this->validateForm($request, null);

        if ($validator->fails()) {
            // Redirigir con el valor deseado para showModal
            return redirect()->route('quote.transport.create')
                ->withErrors($validator)
                ->withInput()
                ->with('showModal', false);
        }

        QuoteTransport::create([
            'shipping_date' => Carbon::now(),
            'response_date' => null,
            'pick_up' => ($request->lcl_fcl === 'LCL') ? $request->pick_up_lcl : $request->pick_up_fcl,
            'delivery' => $request->delivery,
            'container_return' => $request->container_return,
            'contact_phone' => $request->contact_phone,
            'contact_name' => $request->contact_name,
            'max_attention_hour' => $request->max_attention_hour,
            'gang' => $request->gang,
            'guard' => $request->guard,
            'customer_detail' => $request->customer_detail,
            'commodity' => $request->commodity,
            'packaging_type' => $request->packaging_type,
            'load_type' => $request->load_type,
            'container_type' => $request->container_type,
            'ton_kilogram' => $request->ton_kilogram,
            'stackable' => $request->stackable,
            'cubage_kgv' => $request->cubage_kgv,
            'total_weight' => $request->total_weight,
            'packages' => $request->packages,
            'cargo_detail' => $request->cargo_detail,
            'measures' => $request->measures,
            'nro_operation' => $request->nro_operation,
            'lcl_fcl' => $request->lcl_fcl,
            'state' => 'Pendiente'

        ]);


        return "Ok";
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

        return $validator = Validator::make($request->all(), [
            'nro_operation' => 'required|string|unique:quote_transport,nro_operation,' . $id,
            'customer' => 'required|string',
            'pick_up_lcl' => 'required_if:lcl_fcl,LCL',
            'pick_up_fcl' => 'required_if:lcl_fcl,FCL',
            'delivery' => 'required|string',
            'container_return' => 'required_if:lcl_fcl,FCL',
            'contact_name' => 'required|string',
            'contact_phone' => 'required|string',
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
