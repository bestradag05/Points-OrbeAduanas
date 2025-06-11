<?php

namespace App\Http\Controllers;

use App\Models\CommercialQuote;
use App\Models\Concept;
use App\Models\ConceptsQuoteTransport;
use App\Models\ConsolidatedCargos;
use App\Models\Container;
use App\Models\Custom;
use App\Models\Customer;
use App\Models\CustomerSupplierDocument;
use App\Models\Freight;
use App\Models\Incoterms;
use App\Models\Modality;
use App\Models\QuoteFreight;
use App\Models\QuoteTransport;
use App\Models\Regime;
use App\Models\ResponseTransportQuote;
use App\Models\StateCountry;
use App\Models\Supplier;
use App\Models\TypeInsurance;
use App\Models\TypeLoad;
use App\Models\TypeService;
use App\Models\TypeShipment;
use App\Services\CustomService;
use App\Services\FreightService;
use App\Services\TransportService;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use stdClass;

class CommercialQuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $freightService;
    protected $customService;
    protected $transportService;

    public function __construct(FreightService $freightService, TransportService $transportService, CustomService $customService)
    {
        $this->freightService = $freightService;
        $this->transportService = $transportService;
        $this->customService = $customService;
    }

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
        $containers = Container::where('state', 'Activo')->get();
        //Customers
        $personalId = Auth::user()->personal->id;
        $customers = Customer::with('personal')
            ->where('id_personal', $personalId)
            ->get();
            

        return view("commercial_quote/register-commercial-quote", compact('stateCountrys', 'type_shipments', 'type_loads', 'regimes', 'incoterms', 'nro_quote_commercial', 'types_services', 'containers', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $shippersConsolidated = json_decode($request->shippers_consolidated);

        if ($request->is_consolidated) {

            $consolidated = [];

            $consolidated = $this->calculateDataConsolidated($shippersConsolidated);
            
            $commercialQuote = CommercialQuote::create([
                'nro_quote_commercial' => $request->nro_quote_commercial,
                'origin' => $request->origin,
                'destination' => $request->destination,
                'commodity' => $consolidated['commodity'],
                'customer_company_name' => $request->customer_company_name,
                'load_value' => $consolidated['total_load_values'],
                'id_type_shipment' => $request->id_type_shipment,
                'id_regime' => $request->id_regime,
                'id_type_load' => $request->id_type_load,
                'id_incoterms' => $request->id_incoterms,
                'id_containers' =>  $request->id_containers_consolidated,
                'id_customer' => $request->id_customer,
                'container_quantity' => $request->container_quantity_consolidated,
                'lcl_fcl' => $request->lcl_fcl,
                'is_consolidated' => $request->is_consolidated,
                'total_nro_package_consolidated' => $consolidated['total_bultos'],
                'total_volumen_consolidated' => ($consolidated['total_volumen'] > 0) ? $consolidated['total_volumen'] : null,
                'total_kilogram_volumen_consolidated' => ($consolidated['total_kilogram_volumen'] > 0) ? $consolidated['total_kilogram_volumen'] : null,
                'total_kilogram_consolidated' => $consolidated['total_kilogram'],
                'pounds' => $request->pounds,
                'nro_operation' => $request->nro_operation,
                'valid_date' => now()->format('Y-m-d'),
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
                'customer_company_name' => $request->customer_company_name,
                'load_value' => $this->parseDouble($request->load_value),
                'id_type_shipment' => $request->id_type_shipment,
                'id_regime' => $request->id_regime,
                'id_type_load' => $request->id_type_load,
                'id_incoterms' => $request->id_incoterms,
                'commodity' => $request->commodity,
                'nro_package' => $request->nro_package,
                'packaging_type' => $request->packaging_type,
                'id_containers' => $request->id_containers,
                'container_quantity' => $request->container_quantity,
                'id_customer' => $request->id_customer,
                'kilograms' => $request->kilograms != null ? $this->parseDouble($request->kilograms) : null,
                'volumen' => $request->volumen != null ?  $this->parseDouble($request->volumen) : null,
                'kilogram_volumen' => $request->kilogram_volumen != null ? $this->parseDouble($request->kilogram_volumen) : null,
                'tons' => $request->tons != null ?  $this->parseDouble($request->tons) : null,
                'lcl_fcl' => $request->lcl_fcl,
                'is_consolidated' => $request->is_consolidated,
                'measures' => $request->value_measures,
                'pounds' => $request->pounds,
                'nro_operation' => $request->nro_operation,
                'valid_date' => now()->format('Y-m-d'),
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


    public function calculateDataConsolidated($shippersConsolidated)
    {
        $commodityText = [];
        $totalVolumen = 0;
        $totalKilogramVolumen = 0;
        $totalKilogram = 0;
        $totalBultos = 0;
        $totalLoadValue = 0;


        foreach ($shippersConsolidated as $consolidated) {
            $commodityText[] = $consolidated->commodity;
            $totalVolumen += $this->parseDouble($consolidated->volumen);
            $totalKilogramVolumen += $this->parseDouble($consolidated->kilogram_volumen);
            $totalKilogram += $this->parseDouble($consolidated->kilograms);
            $totalBultos += (int) $consolidated->nro_packages_consolidated;
            $totalLoadValue += $this->parseDouble($consolidated->load_value);
        }

        $commodity = implode(', ', $commodityText);

        return [
            'commodity' => $commodity,
            'total_volumen' => $totalVolumen,
            'total_kilogram_volumen' => $totalKilogramVolumen,
            'total_kilogram' => $totalKilogram,
            'total_bultos' => $totalBultos,
            'total_load_values' => $totalLoadValue

        ];
    }


    public function storeConsolidateCarga($shipper, $idCommercialQuote)
    {

        $existSupplier = Supplier::where('name_businessname', $shipper->shipper_name)->first();


        if ($existSupplier) {


            ConsolidatedCargos::create([
                'commercial_quote_id' => $idCommercialQuote,
                'id_incoterms' => $shipper->id_incoterms,
                'supplier_id' => $existSupplier,
                'supplier_temp' => null,
                'commodity' => $shipper->commodity,
                'load_value' => $this->parseDouble($shipper->load_value),
                'nro_packages' => $shipper->nro_packages_consolidated,
                'packaging_type' => $shipper->packaging_type_consolidated,
                'volumen' => $this->parseDouble($shipper->volumen),
                'kilogram_volumen' => $this->parseDouble($shipper->kilogram_volumen),
                'kilograms' => $this->parseDouble($shipper->kilograms),
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
                'id_incoterms' => $shipper->id_incoterms,
                'supplier_id' => null,
                'supplier_temp' => json_encode($tempSupplier),
                'commodity' => $shipper->commodity,
                'load_value' => $this->parseDouble($shipper->load_value),
                'nro_packages' => $shipper->nro_packages_consolidated,
                'packaging_type' => $shipper->packaging_type_consolidated,
                'volumen' => $this->parseDouble($shipper->volumen),
                'kilogram_volumen' => $this->parseDouble($shipper->kilogram_volumen),
                'kilograms' => $this->parseDouble($shipper->kilograms),
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


    public function completeData(Request $request)
    {
        
        $commercialQuote = CommercialQuote::where('nro_quote_commercial', $request->nro_quote_commercial)->first();
        $customer = null;
        $supplier = null;
        $updateData = [
            'state' => 'Aceptado'
        ];


        if ($request->has_customer_data) {

            // Buscar si ya existe un cliente con ese tipo y número de documento
            $customer = Customer::where('id_document', $request->id_document)
                ->where('document_number', $request->document_number)
                ->first();

            if ($customer) {
                // Verificar si el cliente pertenece a otro usuario
                if ($customer->id_personal !== Auth::user()->personal->id) {
                    return back()->with('error', 'El cliente que intentas registrar, esta asignado a otro usuario.');
                }
                // Si pertenece al mismo usuario, se usa tal cual (sin crear uno nuevo)
            } else {
                // Si no existe, se crea uno nuevo
                $customer = Customer::create([
                    'id_document' => $request->id_document,
                    'document_number' => $request->document_number,
                    'name_businessname' => $request->name_businessname,
                    'address' => $request->address,
                    'contact_name' => $request->contact_name,
                    'contact_number' => $request->contact_number,
                    'contact_email' => $request->contact_email,
                    'state' => 'Activo',
                    'id_personal' => Auth::user()->personal->id
                ]);
               
            }

            $updateData['customer_company_name'] = null;
            $updateData['id_customer'] = $customer->id;
        }

        if ($commercialQuote->is_consolidated) {

            foreach ($commercialQuote->consolidatedCargos as $loads) {

                $supplerdata = json_decode($loads->supplier_temp);

                $supplier = Supplier::where('name_businessname', $supplerdata->shipper_name)->first();

                if (!$supplier) {
                    $supplier = Supplier::create([
                        'name_businessname' => $supplerdata->shipper_name,
                        'address' => $supplerdata->shipper_address,
                        'contact_name' => $supplerdata->shipper_contact,
                        'contact_number' => $supplerdata->shipper_contact_phone,
                        'contact_email' => $supplerdata->shipper_contact_email,
                        'state' => 'Activo',
                    ]);
                }
                // Una vez que se acepta, se cambia el supplier temporal por el supplier registrado.
                $loads->update([
                    'supplier_temp' => null,
                    'supplier_id' => $supplier->id
                ]);

                //Obtenemos el supplier que tenga mayor valor de factura, para actualizarlo en la cotizacion

                $maxLoadCargo = $commercialQuote->consolidatedCargos->sortByDesc('load_value')->first();
                $supplierId = $maxLoadCargo->supplier_id;
                $updateData['id_supplier'] = $supplierId;
            }
        } else {

            if ($request->has_supplier_data) {

                // Buscar proveedor por nombre (ajústalo si tienes un campo clave único)
                $supplier = Supplier::where('name_businessname', $request->name_businessname_supplier)->first();

                if (!$supplier) {
                    $supplier = Supplier::create([
                        'name_businessname' => $request->name_businessname_supplier,
                        'address' => $request->address_supplier,
                        'contact_name' => $request->contact_name_supplier,
                        'contact_number' => $request->contact_number_supplier,
                        'contact_email' => $request->contact_email_supplier,
                        'state' => 'Activo',
                    ]);
                }

                $updateData['id_supplier'] = $supplier->id;
            }
        }

        $commercialQuote->update($updateData);

        return redirect('commercial/quote/' . $commercialQuote->id . '/detail')->with('success', 'La cotizacion fue aceptada.');
    }


    public function getTemplateDetailCommercialQuote($id)
    {  

        $comercialQuote = CommercialQuote::find($id);
        $type_services = TypeService::all();
        $modalitys = Modality::all();
        $concepts = Concept::all()->load('typeService');
        $type_insurace = TypeInsurance::all();
        $documents = CustomerSupplierDocument::all();
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
            'customs_agency' => $customs_agency,
            'documents' => $documents
        ];
        

        return view('commercial_quote/detail-commercial-quote', $data);
    }


    public function getTemplateQuoteCommercialQuote(string $id)
    {
        $comercialQuote = CommercialQuote::find($id);

        // 1. Corregir nombre del modelo a singular
        // 2. Usar with() para eager loading de la relación
        // 3. Agregar validación para evitar errores
        $concepts = Concept::with('typeService')
            ->when($comercialQuote->type_shipment, function ($query) use ($comercialQuote) {
                return $query->where('id_type_shipment', $comercialQuote->type_shipment->id);
            })
            ->get();

        $tab = 'quote';

        $data = [
            'comercialQuote' => $comercialQuote,
            'concepts' => $concepts, // 4. Incluir la variable en los datos
            'tab' => $tab,
        ];

        return view('commercial_quote/detail-commercial-quote', $data);
    }


    public function getTemplateDocmentCommercialQuote(string $id)
    {
        $comercialQuote = CommercialQuote::find($id);

        $nroQuoteCommercial = $comercialQuote->nro_quote_commercial;

        $basePath = "public/commercial_quote/{$nroQuoteCommercial}";

        // Verificamos si la carpeta principal existe
        if (Storage::exists($basePath)) {

            // Obtenemos los archivos y subcarpetas dentro de la carpeta principal
            $documents = Storage::allFiles($basePath);  // Devuelve todos los archivos, incluyendo los de subcarpetas
            $directories = Storage::allDirectories($basePath); // Devuelve las subcarpetas
            // Organizar los archivos y subcarpetas de manera jerárquica
            $folders = [];
            foreach ($directories as $directory) {
                // Obtener los archivos dentro de cada subcarpeta
                $folderFiles = Storage::files($directory);
                if (count($folderFiles) > 0) {
                    $folders[] = [
                        'folder' => basename($directory), // Nombre de la subcarpeta
                        'files' => $folderFiles
                    ];
                }
            }
        } else {
            $folders = []; // No se encontró la carpeta
        }


        $tab = 'document';

        $data = [
            'comercialQuote' => $comercialQuote,
            'tab' => $tab,
            'folders' => $folders

        ];


        return view('commercial_quote/detail-commercial-quote', $data);
    }



    public function createQuote(String $nro_quote_commercial, Request $request)
    {

        $commercialQuote = CommercialQuote::where('nro_quote_commercial', $nro_quote_commercial)->first();

        if ($request->type_quote === 'Flete') {

            $this->createQuoteFreight($commercialQuote);
        } else {
            $this->createQuoteTransport($commercialQuote);
        }


        return response()->json([
            'message' => "Cotizacion creada"
        ], 200);
    }


    public function handleActionCommercialQuote(string $action, string $id)
    {


        $commercialQuote = CommercialQuote::findOrFail($id)->first();

        switch ($action) {
            case 'accept':
                # code...

                $commercialQuote->update(['state' => 'Aceptado']);

                break;

            case 'decline':
                # code...

                $commercialQuote->update(['state' => 'Rechazado']);

                break;

            default:
                # code...
                break;
        }

        return redirect('commercial/quote/' . $commercialQuote->id . '/detail');
    }


    public function updateDate(Request $request, string $id)
    {
        $commercialQuote = CommercialQuote::findOrFail($id);
        $validDate = Carbon::createFromFormat('d/m/Y', $request->valid_date)->format('Y-m-d');

        $commercialQuote->update(['valid_date' =>  $validDate]);

        return redirect('commercial/quote/' . $commercialQuote->id . '/detail');
    }


    /**
     * Actualiza los costos netos de los conceptos de transporte (Área de Transporte).
     */
    public function updateTransportCosts(Request $request, $quoteTransportId)
    {
        $request->validate([
            'concepts' => 'required|array',
            'concepts.*.value_concept' => 'required|numeric|min:0', // Costo neto
        ]);

        $quoteTransport = QuoteTransport::findOrFail($quoteTransportId);

        // Actualizar cada concepto en la tabla pivote
        foreach ($request->concepts as $conceptId => $data) {
            $quoteTransport->concepts()->updateExistingPivot($conceptId, [
                'value_concept' => $data['value_concept'],
                'net_amount'    => $data['value_concept'], // net_amount = value_concept (costo base)
                'igv'           => $data['value_concept'] * 0.18, // IGV 18%
                'total'         => $data['value_concept'] * 1.18, // total con IGV
            ]);
        }

        return redirect()->back()->with('success', 'Costos netos actualizados por el área de transporte.');
    }


    public function updateCommercialMargins(Request $request, $quoteTransportId)
    {
        $quoteTransport = QuoteTransport::findOrFail($quoteTransportId);

        foreach ($request->concepts as $conceptId => $data) {
            $quoteTransport->concepts()->updateExistingPivot($conceptId, [
                'added_value' => $data['added_value'],
                'total'       => $quoteTransport->concepts->find($conceptId)->pivot->net_amount + $data['added_value'],
            ]);
        }
    }

    public function storeConceptPrices(Request $request, $quoteId)
{
    $data = $request->validate([
      'provider_id'     => 'required|exists:suppliers,id',
      'price_concept.*' => 'required|numeric|min:0',
      'cost_transport'  => 'required|numeric|min:0',
    ]);

    // 1) Crea o actualiza la respuesta del transportista:
    $resp = ResponseTransportQuote::updateOrCreate(
      ['quote_transport_id' => $quoteId, 'provider_id' => $data['provider_id']],
      ['provider_cost' => $data['cost_transport'], 'status'=>'Enviada']
    );

    $quote = QuoteTransport::findOrFail($quoteId);
    $quote->responseTransportQuotes()->attach($resp->id);

    // 2) Para cada concepto, grábalo en concepts_transport_quote:
    foreach ($data['price_concept'] as $conceptId => $price) {
        $resp->conceptsQuoteTransport()->updateOrCreate(
          ['quote_transport_id' => $quoteId, 'concepts_id' => $conceptId, 'response_quote_id'=>$resp->id],
          ['value_concept' => $price]
        );
    }

    // 3) Redirige con éxito…
    return back()->with('success', 'Cotización de transporte registrada.');
}




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function showCustomerForName(string $name)
    {
        $customer = Customer::where('name_businessname', $name)->first();
        return response()->json($customer);
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

    public function editCommercialQuoteService(string $service, string $id)
    {
        switch ($service) {
            case 'flete':
                # code...

                $data = $this->freightService->editFreight($id);

                return view('freight/edit-freight', $data);

                break;

            case 'aduanas':
                # code...

                $data = $this->customService->editCustom($id);

                return view('custom/edit-custom', $data);

                break;

            case 'transporte':
                # code...

                $data = $this->transportService->editTransport($id);
                return view('transport/edit-transport', $data);

                break;

            default:
                # code...
                break;
        }

        return $service;
    }



    public function getPDF($id)
    {
        $commercialQuote = CommercialQuote::with([
            'quote_freight' => function ($query) {
                $query->where('state', 'Aceptado');
            },
            'quote_transport' => function ($query) {
                $query->where('state', 'Aceptado');
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

        /*   dd($transport->concepts[0]); */



        $pdf = FacadePdf::loadView('commercial_quote.pdf.commercial_quote_pdf', compact('commercialQuote', 'freight', 'custom', 'transport', 'personal'));

        return $pdf->stream('Cotizacion Comercial.pdf'); // Muestra el PDF en el navegador

    }


    public function generateRoPdf($commercialQuote){


        $pdf = FacadePdf::loadView('freight.pdf.routingOrder', compact('commercialQuote'));

        return $pdf->stream('Routing Order.pdf');


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
