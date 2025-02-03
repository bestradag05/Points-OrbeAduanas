<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
use App\Models\ConceptFreight;
use App\Models\Concepts;
use App\Models\Country;
use App\Models\Custom;
use App\Models\Customer;
use App\Models\Freight;
use App\Models\Incoterms;
use App\Models\Insurance;
use App\Models\Modality;
use App\Models\Regime;
use App\Models\Routing;
use App\Models\StateCountry;
use App\Models\Supplier;
use App\Models\Transport;
use App\Models\TypeInsurance;
use App\Models\TypeLoad;
use App\Models\TypeService;
use App\Models\TypeShipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;
use stdClass;

class RoutingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Obtener el ID del personal del usuario autenticado
        $personalId = Auth::user()->personal->id;

        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los routing
            $routings = Routing::with('type_shipment', 'personal')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $routings = Routing::with('type_shipment', 'personal')
                ->where('id_personal', $personalId)
                ->where('state', 'Activo')
                ->get();
        }



        $heads = [
            '#',
            'N° de operacion',
            'Origen',
            'Destino',
            'Cliente',
            'Tipo de embarque',
            'Asesor Comercial',
            'Estado',
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

        //Listamos los customer solo del usuario autenticado
        $personalId = Auth::user()->personal->id;

        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los clientes
            $customers = Customer::with('personal')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $customers = Customer::with('personal')
                ->where('id_personal', $personalId)
                ->get();
        }


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

        /* dd($request->all()); */
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
        $routing = Routing::findOrFail($id);
        $stateCountrys = StateCountry::all()->load('country');

        $type_shipments = TypeShipment::all();
        $modalitys = Modality::all();
        $regimes = Regime::all();

        //Listamos los customer solo del usuario autenticado
        $personalId = Auth::user()->personal->id;

        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los clientes
            $customers = Customer::with('personal')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $customers = Customer::with('personal')
                ->where('id_personal', $personalId)
                ->get();
        }


        $incoterms = Incoterms::all();
        $suppliers = Supplier::all();
        $type_services = TypeService::all();
        $type_loads = TypeLoad::all();


        return view('routing/edit-routing', compact(
            'routing',
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $routing = Routing::findOrFail($id);
        $typeShipment = TypeShipment::findOrFail($request->id_type_shipment);

        if ($typeShipment->description === 'Marítima') {

            $request->merge(["kilogram_volumen" => null]);

            if ($request->lcl_fcl === 'LCL') {

                $request->merge(["tons" => null]);
                $request->merge(["container_type" => null]);
            } else {
                $request->merge(["kilograms" => null]);
            }
        } else {

            $request->merge(["volumen" => null]);
            $request->merge(["tons" => null]);
            $request->merge(["container_type" => null]);
            $request->merge(["lcl_fcl" => null]);
        }


        $request->merge(["measures" =>  $request->value_measures]);


        $routing->update($request->all());

        return redirect('routing');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $routing = Routing::find($id);

        $routing->update(['state' => 'Inactivo']);
        return redirect('routing')->with('eliminar', 'ok');
    }


    public function getNroOperation()
    {
        $lastCode = Routing::latest('id')->first();
        $year = date('y');
        $prefix = 'ORBE-';

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


    public function getTemplateDetailRouting($id)
    {

        $routing = Routing::find($id);
        $routing->load('customer', 'type_shipment', 'regime', 'supplier', 'type_load');
        $type_services = TypeService::all();
        $modalitys = Modality::all();
        $concepts = Concepts::all()->load('typeService');
        $type_insurace = TypeInsurance::all();

        $stateCountrys = StateCountry::whereHas('country', function ($query) {
            $query->where('name', 'Perú');
        })->get();


        $services = [];
        //Verificamos los servicios que esten dentro de nuestro detalle de la carga y lo agregamos
        if ($routing->custom()->exists()) {
            $services['Aduanas'] = $routing->custom->load('insurance');
        }

        if ($routing->freight()->exists()) {
            $services['Flete'] = $routing->freight->load('insurance');
        }

        if ($routing->transport()->exists()) {
            $services['Transporte'] = $routing->transport;
        }


        $tab = 'detail';

        $data = [
            'routing' => $routing,
            'type_services' => $type_services,
            'services' => $services,
            'concepts' => $concepts,
            'modalitys' => $modalitys,
            'tab' => $tab,
            'stateCountrys' => $stateCountrys,
            'type_insurace' => $type_insurace,
            'id_quote_transport' => request('id_quote_transport', null)
        ];



        if ($withdrawal_date = request('withdrawal_date', null)) {
            $data['withdrawal_date'] = $withdrawal_date;
        }

        if ($cost_transport = request('cost_transport', null)) {
            $data['cost_transport'] = $cost_transport;
        }

        if ($origin = request('origin', null)) {
            $data['origin'] = $origin;
        }

        if ($destination = request('destination', null)) {
            $data['destination'] = $destination;
        }

        // Condicionalmente agregar cost_gang si está presente
        if ($cost_gang = request('cost_gang', null)) {
            $data['id_gang_concept'] = request('id_gang_concept', null);
            $data['cost_gang'] = $cost_gang;
        }

        // Condicionalmente agregar cost_guard si está presente
        if ($cost_guard = request('cost_guard', null)) {
            $data['id_guard_concept'] = request('id_guard_concept', null);
            $data['cost_guard'] = $cost_guard;
        }


        return view('routing/detail-routing', $data);
    }


    public function getTemplateDocumentsRouting($id)
    {
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
                    'nro_operation' => $routing->nro_operation,
                    'total_custom' => $request->totalCustom
                ]);


                // Verificamos si tiene seguro
                if ($request->state_insurance) {

                    $sales_price = $request->value_insurance + $request->insurance_added;

                    $insurance = Insurance::create([
                        'insurance_sale' => $sales_price,
                        'sales_value' => $sales_price * 0.18,
                        'sales_price' => $sales_price * 1.18,
                        'id_type_insurance' =>  $request->type_insurance,
                        'name_service' => 'Aduanas',
                        'id_insurable_service' => $custom->id,
                        'model_insurable_service' => Custom::class,
                        'state' => 'Pendiente'
                    ]);

                    $custom->insurance()->save($insurance);

                    //Verificamos si hay puntos adicionales en el seguro

                    if ($request->insurance_points && $this->parseDouble($request->insurance_points) > 0) {


                        $concept = (object) ['name' => 'SEGURO', 'pa' => $request->insurance_points];

                        $ne_amount = $this->parseDouble($request->value_insurance) + $this->parseDouble($request->insurance_added);
                        $igv = $ne_amount * 0.18;
                        $total = $ne_amount + $igv;


                        $this->add_aditionals_point($concept, $custom, $ne_amount, $igv, $total);
                    }
                }


                //Relacionamos los conceptos que tendra esta aduana

                foreach (json_decode($request->concepts) as $concept) {

                    $ne_amount = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);
                    $igv = $ne_amount * 0.18;
                    $total = $ne_amount + $igv;

                    $custom->concepts()->attach($concept->id, [
                        'value_concept' => $concept->value,
                        'added_value' => $concept->added,
                        'net_amount' => round($ne_amount, 2),
                        'igv' => round($igv),
                        'total' => round($total),
                        'additional_points' => isset($concept->pa)
                    ]);

                    //Verificamos si tienen puntos adicionales
                    if (isset($concept->pa)) {
                        $this->add_aditionals_point($concept, $custom, $ne_amount, $igv, $total);
                    }
                }

                return redirect('/routing/' . $routing->id . '/detail');

            case "Flete":
                # Flete...
                // Verificamos si tiene seguro

                //Convertimos el json a un objeto
                $concepts = json_decode($request->concepts);

                $freight = Freight::create([
                    'value_freight' => $request->total,
                    'value_utility' => $request->utility,
                    'state' => 'Pendiente',
                    'nro_operation' => $routing->nro_operation,
                ]);


                if ($request->state_insurance) {

                    $sales_price = $request->value_insurance + $request->insurance_added;

                    $insurance = Insurance::create([
                        'insurance_value' => $request->value_insurance, // precio neto del seguro
                        'insurance_value_added' => $request->insurance_added, // precio agregado del asesor
                        'insurance_sale' => $sales_price,
                        'sales_value' => $sales_price * 0.18,
                        'sales_price' => $sales_price * 1.18,
                        'additional_points' => $request->insurance_points,
                        'id_type_insurance' =>  $request->type_insurance,
                        'name_service' => 'Flete',
                        'id_insurable_service' => $freight->id,
                        'model_insurable_service' => Freight::class,
                        'state' => 'Pendiente'
                    ]);

                    $freight->insurance()->save($insurance);


                    $arrayConcepts = (array) $concepts; //convertimos array los conceptos
                    $lastKey = array_key_last($arrayConcepts); // obtenemos el ultimo indice
                    $key = $lastKey + 1; // agregamos al ultimo indice par acrear el concepto de seguro

                    $concept = Concepts::where('name', 'SEGURO')
                        ->where('id_type_shipment', $freight->routing->type_shipment->id)
                        ->whereHas('typeService', function ($query) {
                            $query->where('name', 'Flete');  // Segunda condición: Filtrar por name del tipo de servicio
                        })
                        ->first();

                    //creamos el objeto del seguro
                    $insuranceObject = new stdClass();

                    $insuranceObject->id = $concept->id;
                    $insuranceObject->name = 'SEGURO';
                    $insuranceObject->value = $request->value_insurance;
                    $insuranceObject->added = $request->insurance_added;
                    $insuranceObject->pa = $request->insurance_points;


                    $concepts->$key = $insuranceObject;
                }

                //Relacionamos los conceptos que tendra este flete

                foreach ($concepts as $concept) {
                    $conceptFreight = ConceptFreight::create([
                        'id_concepts' => $concept->id, // ID del concepto relacionado
                        'id_freight' => $freight->id, // Clave foránea al modelo Freight
                        'value_concept' => $concept->value,
                        'value_concept_added' => $concept->added,
                        'total_value_concept' => $concept->value + $concept->added,
                        'additional_points' => isset($concept->pa) ? $concept->pa : 0,
                    ]);

                    // Si hay puntos adicionales, ejecutamos la función
                    if (isset($concept->pa)) {
                        $ne_amount = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);
                        $this->add_aditionals_point($conceptFreight, $ne_amount);
                    }
                }


                return redirect('/routing/' . $routing->id . '/detail');

            case "Transporte":

                $tax_base = $this->parseDouble($request->transport_value) + $this->parseDouble($request->transport_added);
                $igv = $tax_base * 0.18;
                $total = $tax_base * 1.18;

                $transport = Transport::create([

                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'transport_value' => $this->parseDouble($request->transport_value),
                    'added_value' => $request->transport_added,
                    'tax_base' => $tax_base,
                    'igv' => $igv,
                    'total' => $total,
                    'additional_points' => $request->additional_points,
                    'withdrawal_date' =>  $request->withdrawal_date,
                    'nro_operation' => $routing->nro_operation,
                    'id_quote_transport' => $request->id_quote_transport,
                    'state' => 'Pendiente'

                ]);


                if ($transport->additional_points && $this->parseDouble($transport->additional_points) > 0) {
                    $concept = (object) ['name' => 'TRANSPORTE', 'pa' => $transport->additional_points];

                    $this->add_aditionals_point($concept, $transport, $transport->tax_base, $transport->igv, $transport->total);
                }
                //Relacionamos los conceptos que tendra este transporte

                foreach (json_decode($request->concepts) as $concept) {

                    $ne_amount = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);
                    $igv = $ne_amount * 0.18;
                    $total = $ne_amount + $igv;

                    $transport->concepts()->attach($concept->id, [
                        'value_concept' => $concept->value,
                        'added_value' => $concept->added,
                        'net_amount' => round($ne_amount, 2),
                        'igv' => round($igv),
                        'total' => round($total),
                        'additional_points' => isset($concept->pa)
                    ]);

                    //Verificamos si tienen puntos adicionales
                    if (isset($concept->pa)) {
                        $this->add_aditionals_point($concept, $transport, $ne_amount, $igv, $total);
                    }
                }


                return redirect('/routing/' . $routing->id . '/detail');

            default:
                # code...
                break;
        }
    }


    public function add_aditionals_point($conceptService,  $ne_amount = null, $igv = null, $total = null)
    {


        $additional_point = AdditionalPoints::create([
            'type_of_service' => $conceptService->concepts->name,
            'amount' => ($ne_amount != 0 && $ne_amount != null) ? $ne_amount : $this->parseDouble($conceptService->value_concept) +  $this->parseDouble($conceptService->value_concept_added),
            'igv' => $igv,
            'total' => $total,
            'points' => $conceptService->additional_points,
            'id_additional_concept_service' => $conceptService->id,
            'model_additional_concept_service' => $conceptService::class,
            'additional_type' => ($conceptService::class === 'App\Models\ConceptFreight') ? 'AD-FLETE' : 'AD-ADUANA',
            'state' => 'Pendiente'
        ]);


        $conceptService->additional_point()->save($additional_point);
    }


    public function storeInsuranceService(Request $request)
    {

        $sales_price = $request->value_insurance + $request->insurance_added;
        $model = '';

        if ($request->service_insurance === 'Aduanas') {
            $model = Custom::class;
        } else if ($request->service_insurance === 'Flete') {
            $model = Freight::class;
        }

        Insurance::create([
            'insurance_sale' => $sales_price,
            'sales_value' => $sales_price * 0.18,
            'sales_price' => $sales_price * 1.18,
            'id_type_insurance' =>  $request->type_insurance,
            'name_service' => $request->service_insurance,
            'id_insurable_service' => $request->id_insurable_service,
            'model_insurable_service' => $model,
            'state' => 'Pendiente'
        ]);

        return redirect()->back();
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

    public function getLCLFCL(Request $request)
    {
        $type_shipment = TypeShipment::find($request->idShipment);

        return $type_shipment;
    }
}
