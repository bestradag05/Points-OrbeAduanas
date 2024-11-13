<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

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
                  ->get();
          }

        

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
        $lastCode = Routing::latest('id')->first();
        $year = date('y');
        $prefix = 'ORBE-';

        // Si no hay registros, empieza desde 1
        if (!$lastCode) {
            $codigo = $prefix . $year . '-1';
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



        return view('routing/detail-routing', compact('routing', 'type_services', 'services', 'concepts', 'modalitys', 'tab', 'stateCountrys', 'type_insurace'));
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
        /* dd($request->all()); */
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

                    if($request->insurance_points && $this->parseDouble($request->insurance_points) > 0){
                        

                        $concept =(object) ['name' => 'SEGURO', 'pa' => $request->insurance_points];

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
                    if(isset($concept->pa)){
                        $this->add_aditionals_point($concept, $custom, $ne_amount, $igv, $total);
                    }


                }

                return redirect('/routing/' . $routing->id . '/detail');

            case "Flete":
                # Flete...
                // Verificamos si tiene seguro

                $freight = Freight::create([
                    'value_freight' => $request->total,
                    'value_utility' => $request->utility,
                    'state' => 'Pendiente',
                    'nro_operation' => $routing->nro_operation,
                ]);


                if ($request->state_insurance) {

                    $sales_price = $request->value_insurance + $request->insurance_added;

                    $insurance = Insurance::create([
                        'insurance_sale' => $sales_price,
                        'sales_value' => $sales_price * 0.18,
                        'sales_price' => $sales_price * 1.18,
                        'id_type_insurance' =>  $request->type_insurance,
                        'name_service' => 'Flete',
                        'id_insurable_service' => $freight->id,
                        'model_insurable_service' => Freight::class,
                        'state' => 'Pendiente'
                    ]);

                    $freight->insurance()->save($insurance);



                    if($request->insurance_points && $this->parseDouble($request->insurance_points) > 0){
                        

                        $concept =(object) ['name' => 'SEGURO', 'pa' => $request->insurance_points];

                        $ne_amount = $this->parseDouble($request->value_insurance) + $this->parseDouble($request->insurance_added);


                        $this->add_aditionals_point($concept, $freight, $ne_amount);


                    }
                    


                }


                //Relacionamos los conceptos que tendra este flete

                foreach (json_decode($request->concepts) as $concept) {
                     $freight->concepts()->attach($concept->id, ['value_concept' => $concept->value, 'additional_points' => isset($concept->pa)]);
                  
                    if(isset($concept->pa)){

                        $ne_amount = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);

                        $this->add_aditionals_point($concept, $freight, $ne_amount);
                    }

                }


                return redirect('/routing/' . $routing->id . '/detail');

            case "Transporte":

                $tax_base = $this->parseDouble($request->transport_value) + $this->parseDouble($request->transport_added);
                $igv = $tax_base * 0.18;
                $total = $tax_base * 1.18;

                # Transporte...
                $transport = Transport::create([

                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'transport_value' => $request->transport_value,
                    'added_value' => $request->transport_added,
                    'tax_base' => $tax_base,
                    'igv' => $igv,
                    'total' => $total,
                    'additional_points' => $request->additional_points,
                    'nro_operation' => $routing->nro_operation,
                    'state' => 'Pendiente'

                ]);

                if($transport->additional_points && $this->parseDouble($transport->additional_points) > 0){
                    $concept =(object) ['name' => 'TRANSPORTE', 'pa' => $transport->additional_points];

                    $this->add_aditionals_point($concept, $transport, $transport->tax_base, $transport->igv, $transport->total);
                }

                return redirect('/routing/' . $routing->id . '/detail');

            default:
                # code...
                break;
        }
    }


    public function add_aditionals_point($concept, $service,  $ne_amount = null, $igv = null, $total = null){


        $additional_point = AdditionalPoints::create([
            'type_of_service' => $concept->name,
            'amount' => ($ne_amount != 0 && $ne_amount != null) ? $ne_amount : $this->parseDouble($concept->value) +  $this->parseDouble($concept->added),
            'igv' => $igv,
            'total' => $total,
            'points' => $concept->pa,
            'id_additional_service' => $service->id,
            'model_additional_service' => $service::class,
            'additional_type' =>  ($service::class === 'App\Models\Freight') ? 'AD-FLETE' : 'AD-ADUANA',
            'state' => 'Pendiente'
        ]);

        $service->additional_point()->save($additional_point);


    }


    public function storeInsuranceService(Request $request){

        $sales_price = $request->value_insurance + $request->insurance_added;
        $model = '';

        if($request->service_insurance === 'Aduanas'){
            $model = Custom::class;
        }else if($request->service_insurance === 'Flete')
        {
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

    public function getLCLFCL(Request $request)
    {
        $type_shipment = TypeShipment::find($request->idShipment);

        return $type_shipment;
    }
}
