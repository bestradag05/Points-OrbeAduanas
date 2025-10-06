<?php

namespace App\Services;

use App\Models\ClientQuoteTrace;
use App\Models\CommercialQuote;
use App\Models\Concept;
use App\Models\ConsolidatedCargos;
use App\Models\Container;
use App\Models\CustomDistrict;
use App\Models\Customer;
use App\Models\CustomerSupplierDocument;
use App\Models\Incoterms;
use App\Models\Modality;
use App\Models\PackingType;
use App\Models\QuoteFreight;
use App\Models\QuoteSentClientConcept;
use App\Models\QuotesSentClient;
use App\Models\QuoteTransport;
use App\Models\Regime;
use App\Models\StateCountry;
use App\Models\Supplier;
use App\Models\TypeInsurance;
use App\Models\TypeLoad;
use App\Models\TypeService;
use App\Models\TypeShipment;
use App\Models\Warehouses;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use stdClass;

class CommercialQuoteService
{

    protected $freightService;
    protected $customService;
    protected $transportService;


    public function __construct(FreightService $freightService, TransportService $transportService, CustomService $customService)
    {

        $this->freightService = $freightService;
        $this->transportService = $transportService;
        $this->customService = $customService;
    }


    public function getQuotes(array $filters = [])
    {
        $query = CommercialQuote::with('type_shipment', 'personal');

        $personalId = Auth::user()->personal->id;

        if (!Auth::user()->hasRole('Super-Admin')) {
            $query->where('id_personal', $personalId);
        }

        // Aplicar filtros conocidos
        if (!empty($filters['state'])) {
            $query->where('state', $filters['state']);
        }

        // Puedes seguir agregando más filtros condicionales aquí...

        return [
            'commercial_quotes' => $query->get()
        ];
    }


    public function createCommercialQuote()
    {
        $stateCountrys = StateCountry::all()->load('country');
        $type_shipments = TypeShipment::all();
        $customsDistricts = CustomDistrict::all();
        $type_loads = TypeLoad::all();
        $regimes = Regime::all();
        $incoterms = Incoterms::all();
        $types_services = TypeService::all();
        $packingTypes = PackingType::all();
        $containers = Container::where('state', 'Activo')->get();
        //Customers
        $personalId = Auth::user()->personal->id;
        $customers = Customer::with('personal')
            ->where('id_personal', $personalId)
            ->where('type', 'cliente')
            ->get();

        return compact('stateCountrys', 'type_shipments', 'customsDistricts', 'type_loads', 'regimes', 'incoterms', 'types_services', 'containers', 'customers', 'packingTypes');
    }


    public function storeCommercialQuote($request)
    {
        $typeService = [];
        if ($request->has('type_service_checked')) {
            $typeService = json_decode($request->type_service_checked, true);
        }

        $shippersConsolidated = json_decode($request->shippers_consolidated);

        //Registramos el cliente 
        if ($request->is_customer_prospect == 'prospect') {
            // Si es prospecto, creamos un nuevo cliente
            $customer = Customer::create([
                'name_businessname' => $request->customer_company_name,
                'address' => $request->contact,
                'contact_name' => $request->cellphone,
                'contact_number' => $request->email,
                'contact_email' => $request->email,
                'state' => 'Activo', // o el estado que consideres para prospectos
                'type' => 'prospecto', // Tipo prospecto
                'id_personal' => auth()->user()->personal->id, // Relación con el personal autenticado
            ]);
        } else {
            // Si es cliente, simplemente usamos el ID del cliente desde el frontend
            $customerId = $request->id_customer; // El ID del cliente viene desde el frontend
        }



        if ($request->is_consolidated) {

            $consolidated = [];

            $consolidated = $this->calculateDataConsolidated($shippersConsolidated);

            $commercialQuote = CommercialQuote::create([
                'nro_quote_commercial' => $request->nro_quote_commercial,
                'origin' => $request->origin,
                'destination' => $request->destination,
                'commodity' => $consolidated['commodity'],
                /* 'customer_company_name' => $request->customer_company_name,
                'contact' => $request->contact,
                'cellphone' => $request->cellphone,
                'email' => $request->email, */
                'load_value' => $consolidated['total_load_values'],
                'id_type_shipment' => $request->id_type_shipment,
                'id_customs_district' => $request->id_customs_district,
                'id_regime' => $request->id_regime,
                'id_type_load' => $request->id_type_load,
                'id_incoterms' => $request->id_incoterms,
                'id_containers' =>  $request->id_containers_consolidated,
                'id_customer' => $request->is_customer_prospect == 'prospect' ? $customer->id : $customerId, // Usamos el ID dependiendo de si es prospecto o cliente
                'container_quantity' => $request->container_quantity_consolidated,
                'lcl_fcl' => $request->lcl_fcl,
                'is_consolidated' => $request->is_consolidated,
                'nro_package' => $consolidated['total_bultos'],
                'weight' => $consolidated['total_weight'],
                'unit_of_weight' => $consolidated['unit_of_weight'],
                'volumen_kgv' => $consolidated['total_volumen'],
                'unit_of_volumen_kgv' => $consolidated['unit_of_volumen_kgv'],
                'pounds' => $this->parseDouble($request->pounds),
                'nro_operation' => $request->nro_operation,
                'valid_until' => now()->format('Y-m-d'),
                'services_to_quote' => $typeService,
                'id_personal' => auth()->user()->personal->id,
            ]);

            foreach ($shippersConsolidated as $shipper) {
                $this->storeConsolidateCarga($shipper, $commercialQuote->id);
            }
        } else {


            //Verificamos si es Maritimo y si es FCL o LCL

            if ($request->type_shipment_name === 'Marítima' && $request->lcl_fcl === 'FCL') {

                $data_containers = json_decode($request->data_containers);

                $calcContainers = $this->calculateDataContainers($data_containers);
                $commercialQuote = CommercialQuote::create([
                    'nro_quote_commercial' => $request->nro_quote_commercial,
                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'commodity' => $calcContainers['commodity'],
                    /* 'customer_company_name' => $request->customer_company_name,
                    'contact' => $request->contact,
                    'cellphone' => $request->cellphone,
                    'email' => $request->email, */
                    'load_value' => $calcContainers['total_load_values'],
                    'id_type_shipment' => $request->id_type_shipment,
                    'id_customs_district' => $request->id_customs_district,
                    'id_regime' => $request->id_regime,
                    'id_type_load' => $request->id_type_load,
                    'id_incoterms' => $request->id_incoterms,
                    'id_containers' =>  $request->id_containers_consolidated,
                    'id_customer' => $request->is_customer_prospect == 'prospect' ? $customer->id : $customerId, // Usamos el ID dependiendo de si es prospecto o cliente
                    'container_quantity' => $request->container_quantity_consolidated,
                    'lcl_fcl' => $request->lcl_fcl,
                    'is_consolidated' => $request->is_consolidated,
                    /*          'nro_package' => $calcContainers['total_bultos'],
                    'volumen' => ($calcContainers['total_volumen'] > 0) ? $calcContainers['total_volumen'] : null,
                    'kilogram_volumen' => $request->kilogram_volumen,
                    'kilograms' => $calcContainers['total_weight'], */

                    'weight' => $calcContainers['total_weight'],
                    'unit_of_weight' => $calcContainers['unit_of_weight'],
                    'volumen_kgv' => $calcContainers['total_volumen'],
                    'unit_of_volumen_kgv' => $calcContainers['unit_of_volumen_kgv'],
                    'pounds' => $this->parseDouble($request->pounds),
                    'nro_operation' => $request->nro_operation,
                    'valid_until' => now()->format('Y-m-d'),
                    'services_to_quote' => $typeService,
                    'id_personal' => auth()->user()->personal->id,
                ]);

                foreach ($data_containers as  $container) {

                    $commercialQuote->containersFcl()->attach($container->id_container, [
                        'container_quantity' => $container->container_quantity,
                        'commodity' => $container->commodity,
                        'nro_package' => $container->nro_package,
                        'id_packaging_type' => $container->id_packaging_type,
                        'load_value' =>  $this->parseDouble($container->load_value),
                        'weight' => $container->weight,
                        'unit_of_weight' => $container->unit_of_weight,
                        'volumen_kgv' => $container->volumen_kgv,
                        'unit_of_volumen_kgv' => $container->unit_of_volumen_kgv,
                        'measures' => json_encode($container->value_measures)

                    ]);
                }
            } else {

                $this->validateForm($request, null);

                $commercialQuote = CommercialQuote::create([
                    'nro_quote_commercial' => $request->nro_quote_commercial,
                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    /* 'customer_company_name' => $request->customer_company_name,
                    'contact' => $request->contact,
                    'cellphone' => $request->cellphone,
                    'email' => $request->email, */
                    'load_value' => $this->parseDouble($request->load_value),
                    'id_type_shipment' => $request->id_type_shipment,
                    'id_customs_district' => $request->id_customs_district,
                    'id_regime' => $request->id_regime,
                    'id_type_load' => $request->id_type_load,
                    'id_incoterms' => $request->id_incoterms,
                    'commodity' => $request->commodity,
                    'nro_package' => $request->nro_package,
                    'id_packaging_type' => $request->id_packaging_type,
                    'id_containers' => $request->id_containers,
                    'container_quantity' => $request->container_quantity,
                    'id_customer' => $request->is_customer_prospect == 'prospect' ? $customer->id : $customerId, // Usamos el ID dependiendo de si es prospecto o cliente
                    'weight' => $request->weight,
                    'unit_of_weight' => $request->unit_of_weight,
                    'volumen_kgv' => $request->volumen_kgv,
                    'unit_of_volumen_kgv' => $request->unit_of_volumen_kgv,
                    /* 'kilograms' => $request->kilograms != null ? $this->parseDouble($request->kilograms) : null,
                    'volumen' => $request->volumen != null ?  $this->parseDouble($request->volumen) : null,
                    'kilogram_volumen' => $request->kilogram_volumen != null ? $this->parseDouble($request->kilogram_volumen) : null,
                    'tons' => $request->tons != null ?  $this->parseDouble($request->tons) : null, */
                    'lcl_fcl' => $request->lcl_fcl,
                    'is_consolidated' => $request->is_consolidated,
                    'measures' => $request->value_measures,
                    'pounds' => $this->parseDouble($request->pounds),
                    'nro_operation' => $request->nro_operation,
                    'valid_until' => now()->format('Y-m-d'),
                    'services_to_quote' => $typeService,
                    'id_personal' => auth()->user()->personal->id,
                ]);
            }
        }


        if (!empty($typeService)) {
            foreach ($typeService as $service) {

                switch ($service) {
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


        return $commercialQuote;
    }


    public function completeDataCommercialQuote($request)
    {
        $quoteSentClient = QuotesSentClient::findOrFail($request->quoteSentClient);

        $commercialQuote = $quoteSentClient->commercialQuote;

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
                    return response()->json(['error' => 'El cliente que intentas registrar está asignado a otro usuario.'], 400);
                }

                return response()->json(['error' => 'Ya existe un cliente registrado con ese numero de documento.'], 400);
            } else {
                $customerUpdate = Customer::findOrFail($request->id_customer);

                $customerUpdate->fill([
                    'document_number' => $request->document_number,
                    'name_businessname' => $request->name_businessname,
                    'address' => $request->address,
                    'contact_name' => $request->contact_name,
                    'contact_number' => $request->contact_number,
                    'contact_email' => $request->contact_email,
                    'state' => 'Activo',
                    'id_personal' => Auth::user()->personal->id
                ])->save();
            }
        }



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


        $commercialQuote->update($updateData);
        $quoteSentClient->update($updateData);

        return $commercialQuote;
    }



    public function getTemplateDetailCommercialQuote($id)
    {

        $comercialQuote = CommercialQuote::with(['commercialQuoteContainers.packingType'])->find($id);
        $type_services = TypeService::all();
        $modalitys = Modality::all();
        $concepts = Concept::all()->load('typeService');
        $type_insurace = TypeInsurance::with('insuranceRate')->get();
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
            $customs_taxes = $this->customService->calculateTaxescustom($comercialQuote);
        }

        if ($comercialQuote->transport()->exists()) {
            $services['Transporte'] = $comercialQuote->transport;
        }


        $customs_agency = 0;
        $pleasantOperatives = 35;

        if (isset($comercialQuote->load_value)) {
            if ($comercialQuote->load_value >= 23000) {
                $customs_agency = $comercialQuote->load_value * 0.0045;
            } else {
                $customs_agency = 100;
            }
        }

        // Filtrar los conceptos de "GASTOS OPERATIVOS" y "AGENCIAMIENTO DE ADUANAS"
        $filteredConcepts = [];
        foreach ($concepts as $concept) {
            if (($concept->name === 'GASTOS OPERATIVOS' || $concept->name === 'AGENCIAMIENTO DE ADUANAS') && $comercialQuote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Aduanas') {
                $conceptData = [
                    'id' => $concept->id,
                    'name' => $concept->name,  // Nombre del concepto
                    'value' => 0  // Valor inicial
                ];

                if ($concept->name === 'AGENCIAMIENTO DE ADUANAS') {
                    $conceptData['value'] = $customs_agency;  // Asignamos el precio calculado
                } elseif ($concept->name === 'GASTOS OPERATIVOS') {
                    $conceptData['value'] = $pleasantOperatives;  // Valor fijo para "GASTOS OPERATIVOS"
                }

                $filteredConcepts[] = $conceptData;  // Agregamos al arreglo final
            }
        }


        $tab = 'detail';

        $data = [
            'comercialQuote' => $comercialQuote,
            'type_services' => $type_services,
            'filteredConcepts' => $filteredConcepts,
            'services' => $services,
            'concepts' => $concepts,
            'modalitys' => $modalitys,
            'tab' => $tab,
            'stateCountrys' => $stateCountrys,
            'type_insurace' => $type_insurace,
            'customs_taxes' => $customs_taxes,
            'documents' => $documents
        ];


        return  $data;
    }


    public function assignCostsForCustomsConcepts($concepts) {}



    public function getTemplateQuoteCommercialQuote(string $id)
    {
        $comercialQuote = CommercialQuote::find($id);
        $warehouses = Warehouses::all();

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
            'warehouses' => $warehouses,
            'concepts' => $concepts, // 4. Incluir la variable en los datos
            'tab' => $tab,
        ];

        return $data;
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


        return $data;
    }


    public function storeConsolidateCarga($shipper, $idCommercialQuote)
    {

        $existSupplier = Supplier::where('name_businessname', $shipper->shipper_name)->first();


        if ($existSupplier) {

            ConsolidatedCargos::create([
                'commercial_quote_id' => $idCommercialQuote,
                'id_incoterms' => $shipper->id_incoterms,
                'supplier_id' => $existSupplier->id,
                'supplier_temp' => null,
                'commodity' => $shipper->commodity,
                'load_value' => $this->parseDouble($shipper->load_value),
                'nro_packages' => $shipper->nro_packages_consolidated,
                'id_packaging_type' => $shipper->id_packaging_type_consolidated,
                'weight' => $this->parseDouble($shipper->weight),
                'unit_of_weight' => $shipper->unit_of_weight,
                'volumen_kgv' => $this->parseDouble($shipper->volumen_kgv),
                'unit_of_volumen_kgv' => $shipper->unit_of_volumen_kgv,
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
                'id_packaging_type' => $shipper->id_packaging_type_consolidated,
                'weight' => $this->parseDouble($shipper->weight),
                'unit_of_weight' => $shipper->unit_of_weight,
                'volumen_kgv' => $this->parseDouble($shipper->volumen_kgv),
                'unit_of_volumen_kgv' => $shipper->unit_of_volumen_kgv,
                'value_measures' => ($shipper->value_measures) ? json_encode($shipper->value_measures) : null,
            ]);
        }
    }



    public function createQuote($nro_quote_commercial, $request)
    {

        $commercialQuote = CommercialQuote::where('nro_quote_commercial', $nro_quote_commercial)->first();

        if ($request->type_quote === 'Flete') {

            $this->createQuoteFreight($commercialQuote);
        } else {
            $this->createQuoteTransport($commercialQuote);
        }
    }


    public function handleActionCommercialQuote($action, $id)
    {

        $commercialQuote = CommercialQuote::findOrFail($id)->first();

        switch ($action) {
            case 'accept':
                # code...

                $commercialQuote->update(['state' => 'Aceptado']);

                /*  $this->generatePurePoint($commercialQuote); */

                break;

            case 'decline':
                # code...

                $commercialQuote->update(['state' => 'Rechazado']);

                break;

            default:
                # code...
                break;
        }

        return $commercialQuote;
    }

    /*     public function generatePurePoint($commercialQuote)
    {
        if ($commercialQuote->state === 'Aceptado') {


            $relations = [
                'freight' => $commercialQuote->freight,
                'custom' => $commercialQuote->custom,
                'transport' => $commercialQuote->transport,
                'insurance' => $commercialQuote->insurance
            ];


            foreach ($relations as $key => $relation) {
                // Verificamos si la relación existe
                if ($relation) {
                    // Crear un punto para cada servicio relacionado
                    $relation->points()->create([
                        'pointable_id' => $relation->id,
                        'pointable_type' => get_class($relation),
                        'personal_id' => auth()->user()->personal->id,
                        'point_type' => 'puro', // Tipo de punto (puede ser 'pure' o 'additional')
                        'quantity' => 1 // La cantidad de puntos generados
                    ]);
                }
            }
        }
    } */


    public function updateDate($request, $id)
    {
        $commercialQuote = CommercialQuote::findOrFail($id);
        $validDate = Carbon::createFromFormat('d/m/Y', $request->valid_until)->format('Y-m-d');

        $commercialQuote->update(['valid_until' =>  $validDate]);

        return $commercialQuote;
    }



    public function updateTransportCosts($request, $quoteTransportId)
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
    }


    public function updateCommercialMargins($request, $quoteTransportId)
    {
        $quoteTransport = QuoteTransport::findOrFail($quoteTransportId);

        foreach ($request->concepts as $conceptId => $data) {
            $quoteTransport->concepts()->updateExistingPivot($conceptId, [
                'added_value' => $data['added_value'],
                'total'       => $quoteTransport->concepts->find($conceptId)->pivot->net_amount + $data['added_value'],
            ]);
        }
    }


    public function storeClientTrace($request)
    {
        $request->validate([
            'quote_id' => 'required|exists:commercial_quote,id',
            'client_decision' => 'required|in:accept,decline',
            'justification' => 'required|string|min:5',
        ]);

        $quote = CommercialQuote::findOrFail($request->quote_id);

        // Actualizamos el estado de la cotización según la decisión del cliente
        $quote->state = $request->client_decision === 'accept' ? 'Aceptado' : 'Rechazado';
        $quote->save();

        // Creamos el registro de trazabilidad del cliente
        ClientQuoteTrace::create([
            'quote_id' => $quote->id,
            'client_decision' => $quote->state,
            'justification' => $request->justification,
            'decision_date' => now(),
            'user_id' => Auth::id(),
        ]);

        return  $quote;
    }


    public function showCustomerForName($name)
    {
        $customer = Customer::where('name_businessname', $name)->first();
        return $customer;
    }


    public function editCommercialQuoteService($service, $id)
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


    public function generateRoPdf($commercialQuote)
    {


        $pdf = FacadePdf::loadView('freight.pdf.routingOrder', compact('commercialQuote'));

        return $pdf->stream('Routing Order.pdf');
    }


    public function createQuoteFreight($commercialQuote)
    {
        $packing_type = null;
        if ($commercialQuote->id_packaging_type) {
            $packing_type = $commercialQuote->packingType->name;
        }

        QuoteFreight::create([
            'shipping_date' => null,
            'response_date' => null,
            'origin' => $commercialQuote->originState->country->name . '-' . $commercialQuote->originState->name,
            'destination' =>  $commercialQuote->destinationState->country->name . '-' . $commercialQuote->destinationState->name,
            'commodity' => $commercialQuote->commodity,
            'packaging_type' => $packing_type,
            'load_type' => $commercialQuote->type_load->name,
            'container_type' => $commercialQuote->container_type,
            'weight' => $commercialQuote->weight,
            'unit_of_weight' => $commercialQuote->unit_of_weight,
            'volumen_kgv' => $commercialQuote->volumen_kgv,
            'unit_of_volumen_kgv' => $commercialQuote->unit_of_volumen_kgv,
            'packages' => $commercialQuote->nro_package,
            'measures' => $commercialQuote->measures,
            'nro_quote_commercial' => $commercialQuote->nro_quote_commercial,
            'state' => 'Pendiente'

        ]);
    }

    public function createQuoteTransport($commercialQuote)
    {

        $packing_type = null;
        if ($commercialQuote->id_packaging_type) {
            $packing_type = $commercialQuote->packingType->name;
        }

        QuoteTransport::create([
            /* 'pick_up' => $request->pick_up,
            'delivery' => $request->delivery,
            'container_return' => $request->container_return,
            'gang' => $request->gang,
            'guard' => $request->guard, */
            'commodity' => $commercialQuote->commodity,
            'packaging_type' => $packing_type,
            'load_type' => $commercialQuote->type_load->name,
            'container_type' => $commercialQuote->container_type,
            /* 'stackable' => $request->stackable, */
            'weight' => $commercialQuote->weight,
            'unit_of_weight' => $commercialQuote->unit_of_weight,
            'volumen_kgv' => $commercialQuote->volumen_kgv,
            'unit_of_volumen_kgv' => $commercialQuote->unit_of_volumen_kgv,
            'packages' => $commercialQuote->nro_package,
            'measures' => $commercialQuote->measures,
            'lcl_fcl' => $commercialQuote->lcl_fcl,
            /* 'id_type_shipment' => $request->id_type_shipment, */
            'nro_quote_commercial' => $commercialQuote->nro_quote_commercial,

        ]);
    }


    public function validateForm($request, $id)
    {
        $typeService = [];

        if ($request->has('type_service_checked')) {
            $typeService = json_decode($request->type_service_checked, true);
        }


        $onlyTransport = is_array($typeService) && count($typeService) === 1 && strtolower($typeService[0]) === 'transporte';

        if ($onlyTransport) {
            // Validación solo para transporte
            $request->validate([
                'id_type_shipment' => 'required',
                'id_type_load' => 'required',
                'commodity' => 'required',
                'weight' => 'required',
                'unit_of_weight' => 'required',
                'volumen_kgv' => 'required',
                'unit_of_volumen_kgv' => 'required',
                'lcl_fcl' => 'required_if:type_shipment_name,Marítima',
                'observation' => 'nullable',

                // Validación condicional
                'id_customer' => 'required_if:is_customer_prospect,customer',
                'customer_company_name' => 'required_if:is_customer_prospect,prospect',
                'contact' => 'required_if:is_customer_prospect,prospect',
                'cellphone' => 'required_if:is_customer_prospect,prospect',
                'email' => 'required_if:is_customer_prospect,prospect',
            ]);
        } else {

            $request->validate([
                'origin' => 'required|string',
                'destination' => 'required|string',
                'load_value' => 'required',
                'id_type_shipment' => 'required',
                'id_regime' => 'required',
                'id_type_load' => 'required',
                'id_incoterms' => 'required',
                'commodity' => 'required',
                'weight' => 'required',
                'unit_of_weight' => 'required',
                'volumen_kgv' => 'required',
                'unit_of_volumen_kgv' => 'required',
                'lcl_fcl' => 'required_if:type_shipment_name,Marítima',
                'observation' => 'nullable',

                // Validación condicional
                'id_customer' => 'required_if:is_customer_prospect,customer',
                'customer_company_name' => 'required_if:is_customer_prospect,prospect',
                'contact' => 'required_if:is_customer_prospect,prospect',
                'cellphone' => 'required_if:is_customer_prospect,prospect',
                'email' => 'required_if:is_customer_prospect,prospect',
            ]);
        }
    }


    public function calculateDataConsolidated($shippersConsolidated)
    {
        $commodityText = [];
        $totalVolumen = 0;
        $totalWeight = 0;
        $totalBultos = 0;
        $totalLoadValue = 0;
        $unit_of_weight = '';
        $unit_of_volumen_kgv = '';

        if (count($shippersConsolidated) > 0) {
            // Obtener el primer objeto del array
            $firstContainer = $shippersConsolidated[0];

            // Asignar los valores del primer objeto a las variables correspondientes
            $unit_of_weight = $firstContainer->unit_of_weight;
            $unit_of_volumen_kgv = $firstContainer->unit_of_volumen_kgv;
        }


        foreach ($shippersConsolidated as $consolidated) {
            $commodityText[] = $consolidated->commodity;
            $totalVolumen += $this->parseDouble($consolidated->volumen_kgv);
            $totalWeight += $this->parseDouble($consolidated->weight);
            $totalBultos += (int) $consolidated->nro_packages_consolidated;
            $totalLoadValue += $this->parseDouble($consolidated->load_value);
        }

        $commodity = implode(', ', $commodityText);

        return [
            'commodity' => $commodity,
            'total_volumen' => $totalVolumen,
            'total_weight' => $totalWeight,
            'total_bultos' => $totalBultos,
            'total_load_values' => $totalLoadValue,
            'unit_of_weight' => $unit_of_weight,
            'unit_of_volumen_kgv' => $unit_of_volumen_kgv

        ];
    }

    public function calculateDataContainers($containers)
    {
        $commodityText = [];
        $totalVolumen = 0;
        $totalWeight = 0;
        $totalBultos = 0;
        $totalLoadValue = 0;
        $unit_of_weight = '';
        $unit_of_volumen_kgv = '';

        if (count($containers) > 0) {
            // Obtener el primer objeto del array
            $firstContainer = $containers[0];

            // Asignar los valores del primer objeto a las variables correspondientes
            $unit_of_weight = $firstContainer->unit_of_weight;
            $unit_of_volumen_kgv = $firstContainer->unit_of_volumen_kgv;
        }

        foreach ($containers as $container) {
            $commodityText[] = $container->commodity;
            $totalVolumen += $this->parseDouble($container->volumen_kgv);
            $totalWeight += $this->parseDouble($container->weight);
            $totalBultos += (int) $container->nro_package;
            $totalLoadValue += $this->parseDouble($container->load_value);
        }



        $commodity = implode(', ', $commodityText);

        return [
            'commodity' => $commodity,
            'total_volumen' => $totalVolumen,
            'total_weight' => $totalWeight,
            'total_bultos' => $totalBultos,
            'total_load_values' => $totalLoadValue,
            'unit_of_weight' => $unit_of_weight,
            'unit_of_volumen_kgv' => $unit_of_volumen_kgv

        ];
    }


    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
    }
}
