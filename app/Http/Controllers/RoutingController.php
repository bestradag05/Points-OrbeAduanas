<?php

namespace App\Http\Controllers;

use App\Models\Concepts;
use App\Models\Country;
use App\Models\Custom;
use App\Models\Customer;
use App\Models\Freight;
use App\Models\Incoterms;
use App\Models\Modality;
use App\Models\Regime;
use App\Models\Routing;
use App\Models\StateCountry;
use App\Models\Supplier;
use App\Models\Transport;
use App\Models\TypeLoad;
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
        $suppliers = Supplier::all();
        $type_services = TypeService::all();
        $type_loads = TypeLoad::all();



        return view('routing/register-routing', compact(
            'nro_operation',
            'stateCountrys',
            'customers',
            'type_shipments',
            'modalitys',
            'regimes',
            'incoterms',
            'suppliers',
            'type_services',
            'type_loads'
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
            'id_supplier' => $request->id_supplier,
            'id_type_shipment' => $request->id_type_shipment,
            'id_regime' => $request->id_regime,
            'id_type_load' => $request->id_type_load,
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
        $routing->load('customer', 'type_shipment', 'regime', 'supplier', 'type_load');
        $type_services = TypeService::all();
        $modalitys = Modality::all();
        $concepts = Concepts::all()->load('typeService');
        
        $stateCountrys = StateCountry::whereHas('country', function ($query) {
            $query->where('name', 'Perú');
        })->get();


        $services = [];
        //Verificamos los servicios que esten dentro de nuestro detalle de la carga y lo agregamos
        if ($routing->custom()->exists()) {
            $services['Aduanas'] = $routing->custom ;
        }

        if ($routing->freight()->exists()) {
            $services['Flete'] = $routing->freight;
        }

        if ($routing->transport()->exists()) {
            $services['Transporte'] = $routing->transport;
        }

        $tab = 'detail';



        return view('routing/detail-routing', compact('routing', 'type_services', 'services', 'concepts', 'modalitys', 'tab', 'stateCountrys'));
    }


    public function getTemplateDocumentsRouting($id){
        $tab = 'documents';
        $routing = Routing::find($id);

        $routing_services = $routing->typeService()->get();

        return view('routing/detail-routing', compact('tab', 'routing', 'routing_services'));
    }


    public function storeRoutingService(Request $request)
    {

        $routing = Routing::where('nro_operation', $request->nro_operation)->first();

        $type_services = TypeService::find($request->typeService);

        //Agregamos el registro a la tabla pivot
        $routing->typeService()->attach($type_services);

        switch ($type_services->name) {
            case "Aduanas":
                # Aduana...
                // Creamos nuestro registro de aduanas para los puntos
                $custom = Custom::create([
                    'state' => 'Pendiente',
                    'id_modality' => $request->modality,
                    'nro_operation' => $routing->nro_operation
                ]);

                //Relacionamos los conceptos que tendra esta aduana

                foreach (json_decode($request->conceptos) as $concepto) {
                    $custom->concepts()->attach($concepto->id, ['value_concept' => $concepto->value]);
                }

                return redirect('/routing/' . $routing->id . '/detail');

            case "Flete":
                # Flete...
                $freight = Freight::create([
                    'value_utility' => $request->utility,
                    'state' => 'Pendiente',
                    'nro_operation' => $routing->nro_operation
                ]);

                //Relacionamos los conceptos que tendra esta aduana

                foreach (json_decode($request->conceptos) as $concepto) {
                    $freight->concepts()->attach($concepto->id, ['value_concept' => $concepto->value]);
                }

                return redirect('/routing/' . $routing->id . '/detail');

            case "Seguro":
                # Seguro...
                break;

            case "Transporte":

                  # Transporte...
                Transport::create([

                    'address' => $request->origin . ' - ' . $request->destination,
                    'total' => $request->transport_value,
                    'igv' => (isset($request->igv)) ? (float) $request->transport_value *  0.18 : 0,
                    'tax_base' => (isset($request->igv)) ? (float) $request->transport_value  / 1.18 : $request->transport_value,
                    'nro_operation' => $routing->nro_operation,
                    'state' => 'Pendiente'

                ]);

                return redirect('/routing/' . $routing->id . '/detail');
              

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
            'id_supplier' => 'required',
            'id_type_shipment' => 'required',
            'id_regime' => 'required',
            'id_type_load' => 'required',
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

    public function getLCLFCL(Request $request) {
        $type_shipment = TypeShipment::find($request->idShipment);

        return $type_shipment;
    }
}
