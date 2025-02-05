<?php

namespace App\Http\Controllers;

use App\Models\CommercialQuote;
use App\Models\Concepts;
use App\Models\Incoterms;
use App\Models\Modality;
use App\Models\QuoteFreight;
use App\Models\Regime;
use App\Models\StateCountry;
use App\Models\TypeInsurance;
use App\Models\TypeLoad;
use App\Models\TypeService;
use App\Models\TypeShipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'measures' => $request->value_measures,
            'nro_operation' => $request->nro_operation,
            'observation' => $request->observation,
            'id_personal' => auth()->user()->personal->id,


        ]);


        if (isset($request->type_service) || !empty($request->type_service)) {
            foreach ($request->type_service as $type_service) {

                switch ($type_service) {
                    case 'Flete':

                        $this->createQuoteFreight($commercialQuote);

                        break;
                    case 'Aduanas':
                        # code...
                        break;

                    case 'Transporte':
                        # code...
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }



        return redirect('commercial/quote');
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
            'ton_kilogram' => $commercialQuote->ton_kilogram,
            'cubage_kgv' => $commercialQuote->cubage_kgv,
            'total_weight' => $commercialQuote->total_weight,
            'packages' => $commercialQuote->packages,
            'measures' => $commercialQuote->measures,
            'nro_quote_commercial' => $commercialQuote->nro_quote_commercial,
            'state' => 'Borrador'

        ]);
    }



    public function getTemplateDetailCommercialQuote($id)
    {

        $comercialQuote = CommercialQuote::find($id);
        $type_services = TypeService::all();
        $modalitys = Modality::all();
        $concepts = Concepts::all()->load('typeService');
        $type_insurace = TypeInsurance::all();

        $stateCountrys = StateCountry::whereHas('country', function ($query) {
            $query->where('name', 'Perú');
        })->get();


        $services = [];

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

        ];

        return view('commercial_quote/detail-commercial-quote', $data);
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
            $number = (int) substr($lastCode->nro_operation, 7);
            $number++;
            $codigo = $prefix . $year  . $number;
        }

        return $codigo;
    }
}
