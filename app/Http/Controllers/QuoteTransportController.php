<?php

namespace App\Http\Controllers;

use App\Events\QuoteNotification;
use Illuminate\Support\Facades\DB;
use App\Models\Concepts;
use App\Models\Customer;
use App\Models\ResponseTransportQuote;
use App\Models\ConceptsTransportQuote;
use App\Models\MessageQuoteTransport;
use App\Models\QuoteTransport;
use App\Models\Supplier;
use App\Models\Routing;
use App\Models\TypeShipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class QuoteTransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $quotes = QuoteTransport::with('routing')->get();

        $heads = [
            '#',
            'N° cotizacion',
            'Cliente',
            'Hora maxima de atencion',
            'LCL / FCL',
            'Cubicaje-KGV',
            'Tonelada-KG',
            'Peso Total',
            'Fecha de recojo',
            'Asesor',
            'Estado',
            'Acciones'
        ];

        return view('transport/quote/list_quote', compact('quotes', 'heads'));
    }

    public function getQuoteTransportPersonal()
    {
        // Obtener el ID del personal del usuario autenticado
        $personalId = Auth::user()->personal->id;

        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los routing
            $quotes = QuoteTransport::with('routing', 'customer')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $quotes = QuoteTransport::whereHas('routing', function ($query) use ($personalId) {
                $query->where('id_personal', $personalId);
            })
                ->orWhereHas('customer', function ($query) use ($personalId) {
                    $query->where('id_personal', $personalId);
                })
                ->with('routing', 'customer')
                ->get();
        }


        $heads = [
            '#',
            'N° cotizacion',
            'Nro Operacion',
            'Cliente',
            'Recojo',
            'Entrega',
            'Hora maxima de atencion',
            'LCL / FCL',
            'Cubicaje-KGV',
            'Tonelada-KG',
            'Peso Total',
            'Fecha de recojo',
            'Estado',
            'Acciones'
        ];

        return view('transport/quote/list-quote-personal', compact('quotes', 'heads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Obtener el ID del personal del usuario autenticado
        $personalId = Auth::user()->personal->id;

        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los clientes
            $customers = Customer::with('personal')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $customers = Customer::with('personal')
                ->where('id_personal', $personalId)
                ->get();
        }

        $type_shipments = TypeShipment::all();


        $showModal = session('showModal', true);
        return view('transport.quote.register-quote', compact('customers', 'type_shipments'))->with('showModal', $showModal);
    }


    public function searchRouting($nro_operation)
    {

        $routing = Routing::where('nro_operation', $nro_operation)
            ->where('state', 'Activo')
            ->with('customer', 'type_load', 'type_shipment')
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

        /* dd($request->all()); */

        $validator = $this->validateForm($request, null);

        if ($validator->fails()) {
            // Redirigir con el valor deseado para showModal
            /*  dd($validator->errors()->all()); */
            return redirect()->route('quote.transport.create')
                ->withErrors($validator)
                ->withInput()
                ->with('showModal', false);
        }


        $quote = QuoteTransport::create([
            'shipping_date' => Carbon::now('America/Lima'),
            'response_date' => null,
            'id_customer' => ($request->customer != null) ? $request->customer : $request->customer_manual,
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
            'id_type_shipment' => $request->id_type_shipment,

        ]);


        if ($request->uploaded_files) {

            $nroOperationFolder = "quote_transport/$quote->nro_quote";
            $tempFolder = "uploads/temp";

            if (!Storage::disk('public')->exists($nroOperationFolder)) {
                Storage::disk('public')->makeDirectory($nroOperationFolder);
            }

            foreach ($request->uploaded_files as $file) {
                $tempFilePath = "{$tempFolder}/{$file}";
                $newFilePath = "{$nroOperationFolder}/{$file}";


                if (Storage::disk('public')->exists($tempFilePath)) {
                    Storage::disk('public')->move($tempFilePath, $newFilePath);
                }
            }
        }


        /*  broadcast(new QuoteNotification("Tienes una cotizacion nueva por responder")); */


        return redirect('quote/transport/personal');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // 1) Carga la cotización con relaciones necesarias
        $quote = QuoteTransport::with([
            'messages.sender.personal',
            'commercial_quote',
            'transportConcepts.concept',
            'responseTransportQuotes.supplier',
            'responseTransportQuotes',
        ])->findOrFail($id);

        $displayConcepts = $quote->transportConcepts
            ->map(fn($tc) => $tc->setRelation('concept', $tc->concept));

        $latestResp = $quote
            ->responseTransportQuotes()
            ->orderBy('id', 'desc')
            ->first();


        // 2) Obtengo el id_type_shipment de la cotización
        $shipmentId = $quote->commercial_quote->type_shipment->id;

        // 3) Busco el concepto “TRANSPORTE” que corresponda a ese tipo de shipment
        $transporteConcepts = Concepts::where('name', 'TRANSPORTE')
            ->where('id_type_shipment', $shipmentId)
            ->whereHas('typeService', fn($q) => $q->where('name', 'Transporte'))
            ->first();

        // 4) Inyecto “Transporte” al principio si aún no vino seleccionado
        $chosen = $quote->transportConcepts->keyBy('concepts_id');
        if ($transporteConcepts && ! $chosen->has($transporteConcepts->id)) {
            // Creo un modelo pivot simulado (sin persistir)
            $fake = new \App\Models\ConceptsTransportQuote([
                'concepts_id'   => $transporteConcepts->id,
                'value_concept' => null,
            ]);
            // le asigno la relación 'concept' para que en la vista funcione $fake->concept->name
            $fake->setRelation('concept', $transporteConcepts);
            // lo agrego al inicio
            $quote->setRelation(
                'transportConcepts',
                $quote->transportConcepts->prepend($fake)
            );
        }

        // 5) Mensajes
        $messages = $quote->messages;

        // 6) Archivos
        $folderPath = "commercial_quote/{$quote->commercial_quote->nro_quote_commercial}/quote_transport/{$quote->nro_quote}";
        $files = collect(Storage::disk('public')->files($folderPath))
            ->map(fn($file) => [
                'name' => basename($file),
                'size' => Storage::disk('public')->size($file),
                'url'  => asset("storage/{$file}"),
            ]);

        // 7) Solo proveedores de Transporte
        $transportSuppliers = Supplier::where('area_type', 'transporte')
            ->where('state', 'Activo')
            ->orderBy('name_businessname')
            ->get();

        $status = DB::select("SHOW TABLE STATUS LIKE 'response_transport_quotes'");
        $nextRespId = $status[0]->Auto_increment;
        $nro_response = (new ResponseTransportQuote())->generateNroResponse();

        // 9) Retornar la vista con **todas** las variables
        return view('transport.quote.quote-messagin', [
            'quote'           => $quote,
            'messages'        => $quote->messages,
            'files'           => $files = collect(Storage::disk('public')
                ->files("commercial_quote/{$quote->commercial_quote->nro_quote_commercial}/quote_transport/{$quote->nro_quote}"))
                ->map(fn($f) => [
                    'name' => basename($f),
                    'url'  => asset("storage/{$f}"),
                ]),
            'transportSuppliers' => Supplier::where('area_type', 'transporte')->where('state', 'Activo')->get(),
            'displayConcepts'  => $displayConcepts,
            'latestResp'       => $latestResp,
            'transportSuppliers' => $transportSuppliers,
            'nro_response'     => $nro_response,
            'nextRespId'          => $nextRespId
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $quote = QuoteTransport::findOrFail($id);
        $showModal = false;


        // Obtener el ID del personal del usuario autenticado
        $personalId = Auth::user()->personal->id;

        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los clientes
            $customers = Customer::with('personal')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $customers = Customer::with('personal')
                ->where('id_personal', $personalId)
                ->get();
        }


        //Obtenemos los documentos si es que existen
        $folderPath = "quote_transport/{$quote->nro_quote}";
        $files = collect(Storage::disk('public')->files($folderPath))->map(function ($file) {
            return [
                'name' => basename($file), // Nombre del archivo
                'size' => Storage::disk('public')->size($file), // Tamaño del archivo
                'url' => asset('storage/' . $file), // URL del archivo
            ];
        });


        return view('transport.quote.edit-quote', compact('quote', 'files', 'customers'))->with('showModal', $showModal);
    }

/* Funcion sirve para registar respuesta en responsetransportquote */
    public function storeConceptPrices(Request $request, $quoteId)
    {

        // 1) Validamos
        $data = $request->validate([
            'provider_id'     => 'required|exists:suppliers,id',
            'price_concept.*' => 'required|numeric|min:0',
            'commission'      => 'nullable|numeric|min:0',
        ], [
            'provider_id.required'     => 'Debes seleccionar un proveedor.',
            'price_concept.*.required' => 'Todos los precios de concepto son obligatorios.',
            'commission.required'      => 'La comisión es obligatoria.',
        ]);

        $quote = QuoteTransport::findOrFail($quoteId);

        //  Calculamos el total de conceptos
        $totalConceptos = array_sum($data['price_concept']);



        // Creamos la respuesta de transporte
        $resp = ResponseTransportQuote::create([
            'quote_transport_id' => $quote->id,
            'provider_id'    => $data['provider_id'],
            'provider_cost'  => $totalConceptos, // ahora lo tomamos de conceptos
            'commission'     => $data['commission'] ?? 0,
            'total'          => $totalConceptos + ($data['commission'] ?? 0), // recalcularemos abajo
            'status'         => 'Enviada',
        ]);

        foreach ($data['price_concept'] as $conceptId => $price) {
            $resp->conceptsResponse()->create([
                'concepts_id'    => $conceptId,
                'net_amount'    => $price,   // o aplícale IGV si corresponde: $price / 1.18, etc.
            ]);
        }

        // Generar resumen en HTML  
        $html  = '<div class="card" style="max-width:400px; margin:0 auto;">';
        $html .= '<strong>' . e($resp->rpta_number) . '</strong>';
        $html .= '<table class="table table-sm" style="width:100%; max-width:100%; table-layout:auto;">';
        $html .= '<thead><tr><th>Item</th><th class="text-right">Montos (S/)</th></tr></thead><tbody>';

        // filas de conceptos
        foreach ($data['price_concept'] as $conceptId => $price) {
            $concept = Concepts::find($conceptId);
            $name    = $concept ? $concept->name : "ID #" . $conceptId;
            $html   .= '<tr>';
            $html   .= '<td>' . e($name) . '</td>';
            $html   .= '<td class="text-right">' . number_format($price, 2) . '</td>';
            $html   .= '</tr>';
        }

        // fila comisión
        $commission = $data['commission'] ?? 0;
        $html      .= '<tr>';
        $html      .= '<td>Comision</td>';
        $html      .= '<td class="text-right">' . number_format($commission, 2) . '</td>';
        $html      .= '</tr>';

        // fila total
        $total = $resp->total;
        $html .= '<tr class="font-weight-bold">';
        $html .= '<td>Total</td>';
        $html .= '<td class="text-right">' . number_format($total, 2) . '</td>';
        $html .= '</tr>';

        $html .= '</tbody></table></div>';

        // 6) Guardar como mensaje (ajusta la relación según tu modelo)
        MessageQuoteTransport::create([
            'quote_transport_id' => $quoteId,
            'sender_id'          => auth()->id(),
            'message'            => $html,
        ]);

        return redirect()
            ->route('transport.show', $quoteId)
            ->with('success', 'Cotización de transporte registrada y resumen enviado.');
    }



    public function updateQuoteTransport(Request $request, string $id)
    {
        $quote = QuoteTransport::findOrFail($id);

        //Buscar concepto de transporte manualmente:

        $transporteConcept = Concepts::where('name', 'TRANSPORTE')
            ->where('id_type_shipment', $quote->commercial_quote->id_type_shipment)
            ->whereHas('typeService', fn($q) => $q->where('name', 'Transporte'))
            ->first();

        // 1) Decodificar conceptos enviados desde el modal
        $concepts = json_decode(
            $request->input('conceptsTransportModal', '[]'),
            true      // <- convierte a array asociativo
        );

        $concepts[] = [
            'id' => $transporteConcept->id,
            'nombre' => $transporteConcept->name, // o el valor que quieras por defecto
        ];

        // 2) Obtener la cotización y actualizar solo los campos válidos
        $quote->update([
            'pick_up'          => $request->pick_up,
            'delivery'         => $request->delivery,
            'stackable' => $request->stackable,
            'container_return' => $request->container_return,
        ]);

        //TODO:: Si se va editar, necesitamos eliminar todos los conceptos relacionados primero
        /* $quote->transportConcepts()->delete(); */

        // 4) Insertar cada concepto en la tabla pivot
        foreach ($concepts as $item) {
            $quote->transportConcepts()->create([
                'quote_transport_id' => $quote->id,
                'concepts_id' => $item['id'],
            ]);
        }

        // 5) Preparar los mensajes y archivos como en show()
        $messages = $quote->messages;
        $folderPath = "quote_transport/{$quote->nro_quote}";
        $files = collect(Storage::disk('public')->files($folderPath))
            ->map(fn($file) => [
                'name' => basename($file),
                'size' => Storage::disk('public')->size($file),
                'url'  => asset("storage/{$file}"),
            ]);

        $transportSuppliers = Supplier::where('area_type', 'transporte')
            ->where('state', 'Activo')
            ->orderBy('name_businessname')
            ->get();


        $nro_response = ResponseTransportQuote::generateNroResponse();

        // 7) Renderizar la misma vista y pasarle TODO lo necesario
        return view('transport.quote.quote-messagin', compact(
            'quote',
            'messages',
            'files',
            'transportSuppliers',
            'nro_response'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        /* dd($request->all()); */
        $quote = QuoteTransport::findOrFail($id);

        $request->merge(["pick_up" =>  $request->pick_up_lcl != null ? $request->pick_up_lcl : $request->pick_up_fcl]);
        $request->merge(["state" =>  'Pendiente']);

        $quote->update($request->all());

        if ($request->uploaded_files) {

            $nroOperationFolder = "quote_transport/$quote->nro_quote";
            $tempFolder = "uploads/temp";

            if (!Storage::disk('public')->exists($nroOperationFolder)) {
                Storage::disk('public')->makeDirectory($nroOperationFolder);
            }

            // Obtener los archivos existentes en la carpeta de destino
            $existingFiles = Storage::disk('public')->files($nroOperationFolder);

            foreach ($request->uploaded_files as $file) {
                $tempFilePath = "{$tempFolder}/{$file}";
                $newFilePath = "{$nroOperationFolder}/{$file}";


                if (Storage::disk('public')->exists($tempFilePath)) {
                    Storage::disk('public')->move($tempFilePath, $newFilePath);
                }
            }

            // Eliminar archivos en $nroOperationFolder que no están en uploaded_files
            foreach ($existingFiles as $existingFile) {
                $fileName = basename($existingFile); // Obtener solo el nombre del archivo

                // Si el archivo no está en uploaded_files, eliminarlo
                if (!in_array($fileName, $request->uploaded_files)) {
                    Storage::disk('public')->delete($existingFile);
                }
            }
        }


        return redirect('quote/transport/personal');
    }


    public function costTransport(Request $request, string $id)
    {
        $quote = QuoteTransport::findOrFail($id);

        $quote->update([
            'response_date' => Carbon::now('America/Lima'),
            'cost_transport' => $request->modal_transport_cost,
            'cost_gang' => $request->cost_gang,
            'cost_guard' => $request->cost_guard,
            'state' => 'Respondido'
        ]);

        return redirect('quote/transport');
    }

    public function handleTransportAction(Request $request, string $action, string $id)
    {
        $quote = QuoteTransport::with('routing')->findOrFail($id);


        if ($action === 'accept') {

            //Verificamos si tiene vinculado una operacion, si es null es por que es solo transporte
            if ($quote->nro_operation === null) {

                $withdrawal_date = Carbon::createFromFormat('d/m/Y', $request->withdrawal_date)->format('Y-m-d');

                $concepts = Concepts::all();

                // Agregar cost_gang solo si no es null
                if ($quote->cost_gang !== null) {
                    $concept = Concepts::where('name', 'CUADRILLA')
                        ->where('id_type_shipment', $quote->id_type_shipment)
                        ->get()->first();

                    $params['id_gang_concept'] = $concept->id;
                }

                if ($quote->cost_guard !== null) {

                    $concept = Concepts::where('name', 'RESGUARDO')
                        ->where('id_type_shipment', $quote->id_type_shipment)
                        ->get()->first();

                    $params['id_guard_concept'] = $concept->id;
                }



                $quote->update([
                    'withdrawal_date' => $withdrawal_date,
                    'state' => 'Aceptada'
                ]);

                return view('transport.register-transport', compact('concepts', 'quote', 'params'));
            } else {


                $withdrawal_date = Carbon::createFromFormat('d/m/Y', $request->withdrawal_date)->format('Y-m-d');

                $params = [
                    'id_routing' => $quote->routing->id,
                    'cost_transport' => $quote->cost_transport,
                    'origin' => $quote->pick_up,
                    'destination' => $quote->delivery,
                    'withdrawal_date' => $withdrawal_date,
                    'quote_transport_id' => $quote->id
                ];


                // Agregar cost_gang solo si no es null
                if ($quote->cost_gang !== null) {
                    $concept = Concepts::where('name', 'CUADRILLA')
                        ->where('id_type_shipment', $quote->routing->id_type_shipment)
                        ->get()->first();

                    $params['id_gang_concept'] = $concept->id;
                    $params['cost_gang'] = $quote->cost_gang;
                }

                if ($quote->cost_guard !== null) {

                    $concept = Concepts::where('name', 'RESGUARDO')
                        ->where('id_type_shipment', $quote->routing->id_type_shipment)
                        ->get()->first();

                    $params['id_guard_concept'] = $concept->id;
                    $params['cost_guard'] = $quote->cost_guard;
                }


                $quote->update([
                    'withdrawal_date' => $withdrawal_date,
                    'state' => 'Aceptada'
                ]);


                // Redirigir con los parámetros
                return redirect()->route('routing.detail', $params);
            }
        } else if ($action === 'reajust') {

            $quote->update([
                'readjustment_reason' => $request->readjustment_reason,
                'state' => 'Reajuste'
            ]);

            return redirect('quote/transport/personal');
        } else if ($action === 'responsereajust') {

            $quote->update([
                'old_cost_transport' => $request->modal_transport_old_cost,
                'cost_transport' => $request->modal_transport_readjustment_cost,
                'old_cost_gang' => $request->modal_gang_old_cost,
                'cost_gang' => $request->modal_gang_cost,
                'old_cost_guard' => $request->modal_guard_old_cost,
                'cost_guard' => $request->modal_guard_cost,
                'state' => 'Respondido'
            ]);

            return redirect('quote/transport');
        } else if ($action === 'observation') {

            $quote->update([
                'observations' => $request->observations,
                'state' => 'Observado'
            ]);

            return redirect('quote/transport');
        }
    }


    public function acceptQuoteTransport(Request $request, string $id)
    {

        $quote = QuoteTransport::findOrFail($id);

        $cost_transport = $this->parseDouble($request->cost_transport);
        $cost_gang = $this->parseDouble($request->cost_gang);
        $cost_guard = $this->parseDouble($request->cost_guard);
        $total_transport = $cost_transport + $cost_gang + $cost_guard;


        $quote->update([
            'cost_transport' => $cost_transport,
            'cost_gang' => $cost_gang,
            'cost_guard' =>   $cost_guard,
            'total_transport' =>  $total_transport,
            'withdrawal_date' => $request->withdrawal_date,
            'state' => 'Aceptado'
        ]);

        return redirect('/transport/create/' . $quote->id);
    }

    public function correctedQuoteTransport(string $id)
    {
        $quote = QuoteTransport::findOrFail($id);

        $quote->update([
            'observations' => '',
            'state' => 'Pendiente'
        ]);

        return redirect('quote/transport/personal');
    }


    public function rejectQuoteTransport(string $id)
    {

        $quote = QuoteTransport::findOrFail($id);

        $quote->update([
            'state' => 'Rechazada'
        ]);

        return $quote;
    }

    public function keepQuoteTransport(string $id)
    {

        $quote = QuoteTransport::findOrFail($id);

        $quote->update([
            'state' => 'Respondido'
        ]);

        return redirect('quote/transport');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //


    }


    public function updateStateQuoteTransport(string $id, string $action)
    {

        $quoteTransport = QuoteTransport::findOrFail($id)->first();

        if ($action === 'anular') {
            $quoteTransport->update(['state' => 'Anulado']);
            return response()->json([
                'message' => 'Cotización anulada'
            ]);
        }

        if ($action === 'rechazar') {


            $quoteTransport->update(['state' => 'Rechazado']);

            //Cambiamos de estado al transporte si es que tiene alguno relacionado
            if ($quoteTransport->transport->exists()) {
                $quoteTransport->transport->update(['state' => 'Rechazado']);
            }


            return response()->json([
                'message' => 'Cotización rechazada'
            ]);
        }
    }


    public function uploadFilesQuoteTransport(Request $request)
    {

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename =  $file->getClientOriginalName();

            $path = 'commercial_quote/' . $request->commercial_quote . '/quote_transport/' . $request->transport_quote;

            $file->storeAs($path, $filename, 'public'); // Guardar temporalmente

            $publicUrl = Storage::url($path);

            return response()->json(['success' => true, 'filename' => $filename, 'url' => $publicUrl . "/{$filename}"]);
        }

        return response()->json(['success' => false], 400);
    }

    public function deleteFilesQuoteTransport(Request $request)
    {

        $fileName = $request->input('filename');
        $path = "commercial_quote/{$request->commercial_quote}/quote_transport/{$request->transport_quote}/{$fileName}";

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function validateForm($request, $id)
    {

        /* dd($request->all()); */

        return Validator::make($request->all(), [
            'customer' => 'required_if:nro_operation,!null|nullable|string',
            'customer_manual' => 'required_if:nro_operation,null|nullable|string',
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
            'stackable' => 'required_if:lcl_fcl,LCL',
            'cubage_kgv' => 'required_if:lcl_fcl,LCL',
            'total_weight' => 'required_if:lcl_fcl,LCL',
            'packages' => 'required|string',
            'cargo_detail' => 'nullable',
            'lcl_fcl' => 'required',
        ]);
    }

    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
    }
}
