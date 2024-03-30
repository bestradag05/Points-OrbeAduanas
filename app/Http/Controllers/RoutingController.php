<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Custom;
use App\Models\Customer;
use App\Models\Incoterms;
use App\Models\Modality;
use App\Models\Regime;
use App\Models\Routing;
use App\Models\Shipper;
use App\Models\StateCountry;
use App\Models\TypeService;
use App\Models\TypeShipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listamos los routing

        $routings = Routing::all();
        $routings->load('type_shipment', 'personal');

        $heads = [
            '#',
            'N° de operacion',
            'Origen',
            'Destino',
            'Tipo de embarque',
            'Asesor Comercial',
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
        $customers = Customer::all();
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
            'shippers',
            'type_services'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Creamos un routing

        $this->validateForm($request, null);

        Routing::create([
            'nro_operation' => $request->nro_operation,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'load_value' => $this->parseDouble($request->load_value),
            'id_customer' => $request->id_customer,
            'id_shipper' => $request->id_shipper,
            'id_type_shipment' => $request->id_type_shipment,
            'id_regime' => $request->id_regime,
            'id_incoterms' => $request->id_incoterms,
            'wr_loading' => $request->wr_loading,
            'commodity' => $request->commodity,
            'nro_package' => $request->nro_package,
            'pounds' => $request->pounds,
            'kilograms' => $this->parseDouble($request->kilograms),
            'meassurement' => $this->parseDouble($request->meassurement),
            'hs_code' => $request->hs_code,
            'nro_operation' => $request->nro_operation,
            'observation' => $request->observation,
            'id_personal' => auth()->user()->personal->id,


        ]);


        return redirect('routing');
    }

    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
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


    public function getNroOperation()
    {
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


    public function getTemplateDetailRouting($id)
    {

        $routing = Routing::find($id);
        $routing->load('customer', 'type_shipment', 'regime', 'shipper');
        $type_services = TypeService::all();

        $routing_services = $routing->typeService()->get();

        /* dd($routing_services); */

        return view('routing/detail-routing', compact('routing', 'type_services', 'routing_services'));
    }


    public function storeRoutingService(Request $request)
    {
        switch ((Integer) $request->typeService) {
            case 1:
                # Aduana...

                $routing = Routing::where('nro_operation', $request->nro_operation)->first();
                $type_services = TypeService::find($request->typeService);
                //Agregamos el registro a la tabla pivot
                $routing->typeService()->attach($type_services);

                Custom::create([
                    'state' => 'Pendiente',
                    'nro_operation' => $routing->nro_operation
                ]);

                return redirect('/routing/'. $routing->id . '/detail');

                break;

            case 2:
                # Flete...
                dd($request->all());
                break;

            case 3:
                # Seguro...
                break;

            case 4:
                # Transporte...
                break;

            default:
                # code...
                break;
        }

    }

    public function validateForm($request, $id)
    {
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
            'kilograms' => 'required',
            'meassurement' => 'required',
            'hs_code' => 'nullable',
            'observation' => 'nullable'
        ]);
    }
}
