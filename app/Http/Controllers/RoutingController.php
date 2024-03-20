<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Customer;
use App\Models\Incoterms;
use App\Models\Modality;
use App\Models\Regime;
use App\Models\Routing;
use App\Models\Shipper;
use App\Models\StateCountry;
use App\Models\TypeShipment;
use Illuminate\Http\Request;

class RoutingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listamos los routing

        $routings = Routing::all();

        $heads = [
            '#',
            'N° de operacion',
            'Origen',
            'Destino',
            'Acciones'
        ];

        return view('routing/list-routing', compact('routings', 'heads'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Formulario para registrar

        $nro_operation = $this->getNroOperation();
        $stateCountrys = StateCountry::all()->load('country');

        $type_shipments = TypeShipment::all();
        $modalitys = Modality::all();
        $regimes = Regime::all();
        $customers= Customer::all();
        $incoterms = Incoterms::all();
        $shippers = Shipper::all();



        return view('routing/register-routing', compact(
            'nro_operation', 
            'stateCountrys', 
            'customers', 
            'type_shipments', 
            'modalitys',
            'regimes',
            'incoterms',
            'shippers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        
        $this->validateForm($request, null );
            

        
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


    public function getNroOperation(){
        $lastCode = Routing::latest()->value('nro_operation');
        $year = date('y');
        $prefix = 'ORBE-';

        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            $codigo = $prefix . $year . '-1';
        } else {
            // Extraer el número y aumentarlo
            $number = (int) substr($lastCode, 7);
            $number++;
            $codigo = $prefix . $year  . $number;
        }

        return $codigo;
    }

    public function validateForm($request, $id){
        $request->validate([
            'nro_operation' => 'required|string|unique:routing,nro_operation,' . $id,
            'origin' => 'required|string',
            'destination' => 'required|string',
            'load_value' => 'required',
            'id_customer' => 'required',
            'id_shipper' => 'required',
            'id_type_shipment' => 'required',
            'id_regime' => 'required',
            'id_incoterms' => 'required',
            'wr_loading' => 'nullable',
            'commodity' => 'required',
            'nro_package' => 'nullable',
            'pounds' => 'nullable',
            'kilograms' => 'nullable',
            'meassurement' => 'nullable',
            'hs_code' => 'nullable',
            'observation' => 'nullable'
        ]);
    
    }
}
