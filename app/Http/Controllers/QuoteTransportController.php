<?php

namespace App\Http\Controllers;

use App\Events\QuoteNotification;
use App\Models\Concepts;
use App\Models\Customer;
use App\Models\QuoteTransport;
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
    public function show(string $id)
    {
        //Ver el detalle de la cotizacion

        $quote = QuoteTransport::findOrFail($id);
        $messages = $quote->messages;

        $folderPath = "quote_transport/{$quote->nro_quote}";
        $files = collect(Storage::disk('public')->files($folderPath))->map(function ($file) {
            return [
                'name' => basename($file), // Nombre del archivo
                'size' => Storage::disk('public')->size($file), // Tamaño del archivo
                'url' => asset('storage/' . $file), // URL del archivo
            ];
        });

        return view('transport/quote/quote-messagin', compact('quote', 'files', 'messages'));
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

    public function updateQuoteTransport(Request $request, string $id){
        $quote = QuoteTransport::findOrFail($id);

        $quote->update($request->all());

        $folderPath = "quote_transport/{$quote->nro_quote}";
        $files = collect(Storage::disk('public')->files($folderPath))->map(function ($file) {
            return [
                'name' => basename($file), // Nombre del archivo
                'size' => Storage::disk('public')->size($file), // Tamaño del archivo
                'url' => asset('storage/' . $file), // URL del archivo
            ];
        });
        


        $messages = $quote->messages;

        return view('transport/quote/quote-messagin', compact('quote', 'messages', 'files'));

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
                    'id_quote_transport' => $quote->id
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


    public function acceptQuoteTransport(string $id)
    {

        $quote = QuoteTransport::with('routing')->findOrFail($id);


        $params = [
            'id_routing' => $quote->routing->id,
            'cost_transport' => $quote->cost_transport,
            'origin' => $quote->pick_up,
            'destination' => $quote->delivery,
            'withdrawal_date' => $quote->withdrawal_date,
            'id_quote_transport' => $quote->id
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
            'withdrawal_date' => $quote->withdrawal_date,
            'state' => 'Aceptada'
        ]);


        // Redirigir con los parámetros
        return redirect()->route('routing.detail', $params);
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


    public function uploadFilesQuoteTransport(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename =  $file->getClientOriginalName();
            $file->storeAs('uploads/temp', $filename, 'public'); // Guardar temporalmente

            return response()->json(['success' => true, 'filename' => $filename]);
        }

        return response()->json(['success' => false], 400);
    }

    public function deleteFilesQuoteTransport(Request $request)
    {

        $filename = $request->input('filename');
        $filePath = "uploads/temp/{$filename}";

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
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
}
