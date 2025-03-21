<?php

namespace App\Http\Controllers;

use App\Models\CommercialQuote;
use App\Models\Concepts;
use App\Models\ConsolidatedCargos;
use App\Models\Custom;
use App\Models\Incoterms;
use App\Models\Modality;
use App\Models\QuoteFreight;
use App\Models\QuoteTransport;
use App\Models\Regime;
use App\Models\StateCountry;
use App\Models\Supplier;
use App\Models\TypeInsurance;
use App\Models\TypeLoad;
use App\Models\TypeService;
use App\Models\TypeShipment;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class CommercialQuoteController extends Controller
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
            $commercial_quotes = CommercialQuote::with('type_shipment', 'personal')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $commercial_quotes = CommercialQuote::with('type_shipment', 'personal')
                ->where('id_personal', $personalId)
                ->where('state', 'Activo')
                ->get();
        }




        $heads = [
            '#',
            'N° de cotizacion',
            'Origen',
            'Destino',
            'Cliente',
            'Tipo de embarque',
            'Asesor Comercial',
            'Consolidado',
            'Fecha',
            'Estado',
            'Acciones'
        ];

        return view('commercial_quote/list-commercial-quote', compact('commercial_quotes', 'heads'));
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
        $shippersConsolidated = json_decode($request->shippers_consolidated);

        if ($request->is_consolidated) {

            $totalLoadValue = collect($shippersConsolidated)
                ->map(fn($shipper) => ['load_value' => $this->parseDouble($shipper->load_value)])
                ->sum('load_value');

            $commercialQuote = CommercialQuote::create([
                'nro_quote_commercial' => $request->nro_quote_commercial,
                'origin' => $request->origin,
                'destination' => $request->destination,
                'customer_ruc' => $request->customer_ruc != null ?  $request->customer_ruc : null,
                'customer_company_name' => $request->customer_company_name != null ?  $request->customer_company_name : null,
                'load_value' => $totalLoadValue,
                'id_type_shipment' => $request->id_type_shipment,
                'id_regime' => $request->id_regime,
                'id_type_load' => $request->id_type_load,
                'id_incoterms' => $request->id_incoterms,
                'container_type' => $request->container_type,
                'lcl_fcl' => $request->lcl_fcl,
                'is_consolidated' => $request->is_consolidated,
                'nro_operation' => $request->nro_operation,
                'observation' => $request->observation,
                'id_personal' => auth()->user()->personal->id,
            ]);

            foreach ($shippersConsolidated as $shipper) {
                $this->storeConsolidateCarga($shipper, $commercialQuote->id);
            }
        } else {
            $this->validateForm($request, null);

            $commercialQuote = CommercialQuote::create([
                'nro_quote_commercial' => $request->nro_quote_commercial,
                'origin' => $request->origin,
                'destination' => $request->destination,
                'customer_ruc' => $request->customer_ruc != null ?  $request->customer_ruc : null,
                'customer_company_name' => $request->customer_company_name != null ?  $request->customer_company_name : null,
                'load_value' => $this->parseDouble($request->load_value),
                'id_type_shipment' => $request->id_type_shipment,
                'id_regime' => $request->id_regime,
                'id_type_load' => $request->id_type_load,
                'id_incoterms' => $request->id_incoterms,
                'commodity' => $request->commodity,
                'nro_package' => $request->nro_package,
                'packaging_type' => $request->packaging_type,
                'container_type' => $request->container_type,
                'kilograms' => $request->kilograms != null ? $this->parseDouble($request->kilograms) : null,
                'volumen' => $request->volumen != null ?  $this->parseDouble($request->volumen) : null,
                'kilogram_volumen' => $request->kilogram_volumen != null ? $this->parseDouble($request->kilogram_volumen) : null,
                'tons' => $request->tons != null ?  $this->parseDouble($request->tons) : null,
                'lcl_fcl' => $request->lcl_fcl,
                'is_consolidated' => $request->is_consolidated,
                'measures' => $request->value_measures,
                'nro_operation' => $request->nro_operation,
                'observation' => $request->observation,
                'id_personal' => auth()->user()->personal->id,
            ]);
        }


        if (isset($request->type_service) || !empty($request->type_service)) {
            foreach ($request->type_service as $type_service) {

                switch ($type_service) {
                    case 'Flete':

                        $this->createQuoteFreight($commercialQuote);

                        break;
                    case 'Transporte':

                        $this->createQuoteTransport($commercialQuote);

                        break;

                    default:
                        # code...
                        break;
                }
            }
        }

        return redirect('commercial/quote/' . $commercialQuote->id . '/detail');
    }


    public function storeConsolidateCarga($shipper, $idCommercialQuote)
    {

        $existSupplier = Supplier::where('name_businessname', $shipper->shipper_name)->first();


        if ($existSupplier) {


            ConsolidatedCargos::create([
                'commercial_quote_id' => $idCommercialQuote,
                'supplier_id' => $existSupplier,
                'supplier_temp' => null,
                'commodity' => $shipper->commodity,
                'load_value' => $this->parseDouble($shipper->load_value),
                'nro_packages' => $shipper->nro_packages_consolidated,
                'packaging_type' => $shipper->packaging_type_consolidated,
                'volumen' => $this->parseDouble($shipper->volumen),
                'kilograms' => $this->parseDouble($shipper->volumen),
                'value_measures' => ($shipper->value_measures) ? json_encode($shipper->value_measures) : null,
            ]);
        } else {


            $tempSupplier = [
                "shipper_name" =>  $shipper->shipper_name,
                "shipper_contact" =>  $shipper->shipper_contact,
                "shipper_contact_email" =>  $shipper->shipper_contact_email,
                "shipper_contact_phone" =>  $shipper->shipper_contact_phone,
                "shipper_address" =>  $shipper->shipper_address
            ];

            ConsolidatedCargos::create([
                'commercial_quote_id' => $idCommercialQuote,
                'supplier_id' => null,
                'supplier_temp' => json_encode($tempSupplier),
                'commodity' => $shipper->commodity,
                'load_value' => $this->parseDouble($shipper->load_value),
                'nro_packages' => $shipper->nro_packages_consolidated,
                'packaging_type' => $shipper->packaging_type_consolidated,
                'volumen' => $this->parseDouble($shipper->volumen),
                'kilograms' => $this->parseDouble($shipper->volumen),
                'value_measures' => ($shipper->value_measures) ? json_encode($shipper->value_measures) : null,
            ]);
        }
    }


    public function createQuoteFreight($commercialQuote)
    {
        QuoteFreight::create([
            'shipping_date' => null,
            'response_date' => null,
            'origin' => $commercialQuote->origin,
            'destination' => $commercialQuote->destination,
            'commodity' => $commercialQuote->commodity,
            'packaging_type' => $commercialQuote->packaging_type,
            'load_type' => $commercialQuote->type_load->name,
            'container_type' => $commercialQuote->container_type,
            'ton_kilogram' => $commercialQuote->kilograms ? $commercialQuote->kilograms : $commercialQuote->tons,
            'cubage_kgv' => $commercialQuote->kilogram_volumen ? $commercialQuote->kilogram_volumen : $commercialQuote->volumen,
            'total_weight' => $commercialQuote->total_weight,
            'packages' => $commercialQuote->nro_package,
            'measures' => $commercialQuote->measures,
            'nro_quote_commercial' => $commercialQuote->nro_quote_commercial,
            'state' => 'Pendiente'

        ]);
    }

    public function createQuoteTransport($commercialQuote)
    {
        
        QuoteTransport::create([
            /* 'pick_up' => $request->pick_up,
            'delivery' => $request->delivery,
            'container_return' => $request->container_return,
            'gang' => $request->gang,
            'guard' => $request->guard, */
            'commodity' => $commercialQuote->commodity,
            'packaging_type' => $commercialQuote->packaging_type,
            'load_type' => $commercialQuote->type_load->name,
            'container_type' => $commercialQuote->container_type,
            'ton_kilogram' => ($commercialQuote->lcl_fcl === 'FCL') ? $commercialQuote->tons : $commercialQuote->kilograms,
            /* 'stackable' => $request->stackable, */
            'cubage_kgv' => ($commercialQuote->lcl_fcl === 'FCL' || $commercialQuote->lcl_fcl === 'LCL') ? $commercialQuote->volumen : $commercialQuote->kilogram_volumen,
            'packages' => $commercialQuote->nro_package,
            'measures' => $commercialQuote->measures,
            'lcl_fcl' => $commercialQuote->lcl_fcl,
            /* 'id_type_shipment' => $request->id_type_shipment, */
            'nro_quote_commercial' => $commercialQuote->nro_quote_commercial,

        ]);
    }



    public function getTemplateDetailCommercialQuote($id)
    {

        $comercialQuote = CommercialQuote::find($id);
        $type_services = TypeService::all();
        $modalitys = Modality::all();
        $concepts = Concepts::all()->load('typeService');
        $type_insurace = TypeInsurance::all();
        $customs_taxes = new stdClass();

        $stateCountrys = StateCountry::whereHas('country', function ($query) {
            $query->where('name', 'Perú');
        })->get();


        $services = [];
        //Verificamos los servicios que esten dentro de nuestro detalle de la carga y lo agregamos
        if ($comercialQuote->custom()->exists()) {
            $services['Aduanas'] = $comercialQuote->custom->load('insurance');
        }

        if ($comercialQuote->freight()->exists()) {
            $services['Flete'] = $comercialQuote->freight->load('insurance');

            //Calculamos impuestos para la aduana si es que lo llega a usar.

            $customs_taxes_value = $comercialQuote->cif_value * 0.18;
            $customs_perception_value = ($comercialQuote->cif_value + $customs_taxes_value) * 0.035;

            $customs_taxes->customs_taxes = number_format($customs_taxes_value, 2);
            $customs_taxes->customs_perception = number_format($customs_perception_value, 2);
        }

        if ($comercialQuote->transport()->exists()) {
            $services['Transporte'] = $comercialQuote->transport;
        }


        $customs_agency = 0;

        if (isset($comercialQuote->load_value)) {

            if ($comercialQuote->load_value >= 23000) {
                $customs_agency  = $comercialQuote->load_value * 0.004;
            } else {
                $customs_agency = 100;
            }
        }


        $tab = 'detail';

        $data = [
            'comercialQuote' => $comercialQuote,
            'type_services' => $type_services,
            'services' => $services,
            'concepts' => $concepts,
            'modalitys' => $modalitys,
            'tab' => $tab,
            'stateCountrys' => $stateCountrys,
            'type_insurace' => $type_insurace,
            'customs_taxes' => $customs_taxes,
            'customs_agency' => $customs_agency

        ];


        return view('commercial_quote/detail-commercial-quote', $data);
    }


    public function createQuote(String $nro_quote_commercial, Request $request){
        

        $commercialQuote = CommercialQuote::where('nro_quote_commercial', $nro_quote_commercial)->first();

        if($request->type_quote === 'Flete'){

            $this->createQuoteFreight($commercialQuote);


        }else{
            $this->createQuoteTransport($commercialQuote);
        }
        

        return response()->json([
            'message' => "Cotizacion creada"
        ], 200);

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


    public function getPDF($id)
    {

        $commercialQuote = CommercialQuote::with([
            'quote_freight' => function ($query) {
                $query->where('state', 'Aceptada');
            },
            'quote_transport' => function ($query) {
                $query->where('state', 'Aceptada');
            }
        ])->find($id);


        $personal = Auth::user()->personal;


        $freight = [];
        $custom  = [];
        $transport = [];


        if ($commercialQuote->quote_freight->isNotEmpty()) {
            $freight = $commercialQuote->quote_freight->first()?->freight;
        }

        if ($commercialQuote->custom && $commercialQuote->custom->exists()) {
            $custom = $commercialQuote->custom;
        }

        if ($commercialQuote->quote_transport->isNotEmpty()) {
            $transport = $commercialQuote->quote_transport->first()?->transport;
        }

        $commercialQuoteArray = $commercialQuote->toArray(); // Convierte el modelo a un array



        $pdf = FacadePdf::loadView('commercial_quote.pdf.commercial_quote_pdf', compact('commercialQuote', 'freight', 'custom', 'transport', 'personal'));

        return $pdf->stream('Cotizacion Comercial.pdf'); // Muestra el PDF en el navegador

    }

    public function validateForm($request, $id)
    {

        /* dd($request->all()); */

        $request->validate([
            'nro_quote_commercial' => 'required|string|unique:commercial_quote,nro_quote_commercial,' . $id,
            'origin' => 'required|string',
            'destination' => 'required|string',
            'load_value' => 'required',
            'id_type_shipment' => 'required',
            'id_regime' => 'required',
            'id_type_load' => 'required',
            'id_incoterms' => 'required',
            'commodity' => 'required',
            'kilograms' => 'required_unless:lcl_fcl,FCL',
            'volumen' => 'required_if:type_shipment_name,Marítima',
            'kilogram_volumen' => 'required_if:type_shipment_name,Aérea',
            'tons' => 'required_if:lcl_fcl,FCL|max:8',
            'lcl_fcl' => 'required_if:type_shipment_name,Marítima',
            'observation' => 'nullable'
        ]);
    }

    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
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
            $number = (int) substr($lastCode->nro_quote_commercial, 7);
            $number++;
            $codigo = $prefix . $year  . $number;
        }

        return $codigo;
    }
}
