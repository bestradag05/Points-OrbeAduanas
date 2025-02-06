<?php

namespace App\Http\Controllers;

use App\Models\QuoteFreight;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class QuoteFreightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = QuoteFreight::with('routing')->get();

        $heads = [
            '#',
            'N° cotizacion',
            'Cliente',
            'Origen',
            'Destino',
            'Producto',
            'LCL / FCL',
            'Cubicaje-KGV',
            'Tonelada-KG',
            'Asesor',
            /* 'N° de operacion', */
            'N° de Cotizacion',
            'Estado',
            'Acciones'
        ];

        return view('freight/quote/list-quote', compact('quotes', 'heads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Obtener el ID del personal del usuario autenticado
         $personalId = Auth::user()->personal->id;

 
 
         $showModal = session('showModal', true);
         return view('freight.quote.register-quote')->with('showModal', $showModal);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validateForm($request, null);

        if ($validator->fails()) {
            // Redirigir con el valor deseado para showModal
            /*  dd($validator->errors()->all()); */
            return redirect()->route('quote.freight.create')
                ->withErrors($validator)
                ->withInput()
                ->with('showModal', false);
        }


        $quote = QuoteFreight::create([
            'shipping_date' => null,
            'response_date' => null,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'commodity' => $request->commodity,
            'packaging_type' => $request->packaging_type,
            'load_type' => $request->load_type,
            'container_type' => $request->container_type,
            'ton_kilogram' => $request->ton_kilogram,
            'cubage_kgv' => $request->cubage_kgv,
            'total_weight' => $request->total_weight,
            'packages' => $request->packages,
            'measures' => $request->measures,
            'nro_operation' => $request->nro_operation,
            'state' => 'Borrador'

        ]);


        if ($request->uploaded_files) {

            $nroOperationFolder = "quote_freight/$quote->nro_quote";
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


        return redirect('/quote/freight/'. $quote->id);
    }


    public function acceptQuoteFreight(Request $request, $id)
    {
        $quote = QuoteFreight::findOrFail($id);

        $ocean_freight = $this->parseDouble($request->ocean_freight); 
        $utility = $this->parseDouble($request->utility); 
        $operations_commission = $this->parseDouble($request->operations_commission); 
        $pricing_commission = $this->parseDouble($request->pricing_commission); 
        $total_ocean_freight = $ocean_freight + $utility + $operations_commission +  $pricing_commission;


        $quote->update([
            'ocean_freight' => $ocean_freight,
            'utility' => $utility,
            'operations_commission' =>   $operations_commission,
            'pricing_commission' =>  $pricing_commission,
            'total_ocean_freight' => $total_ocean_freight,
            'state' => 'Aceptada'
        ]);

        return redirect('/freight/create/'. $quote->id);
    }

    public function uploadFilesQuoteFreight(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename =  $file->getClientOriginalName();
            $file->storeAs('uploads/temp', $filename, 'public'); // Guardar temporalmente

            return response()->json(['success' => true, 'filename' => $filename]);
        }

        return response()->json(['success' => false], 400);
    }

    public function deleteFilesQuoteFreight(Request $request)
    {
        $filename = $request->input('filename');
        $filePath = "uploads/temp/{$filename}";

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $quote = QuoteFreight::findOrFail($id);

        $folderPath = "quote_freight/{$quote->nro_quote}";
        $files = collect(Storage::disk('public')->files($folderPath))->map(function ($file) {
            return [
                'name' => basename($file), // Nombre del archivo
                'size' => Storage::disk('public')->size($file), // Tamaño del archivo
                'url' => asset('storage/' . $file), // URL del archivo
            ];
        });
        
        
        $messages = QuoteFreight::findOrFail($id)->messages;


        return view('freight/quote/quote-messagin', compact('quote', 'files', 'messages'));
    }


    public function sendQuote(string $id){
        

        $quote = QuoteFreight::findOrFail($id);

        $quote->update([
            'shipping_date' => Carbon::now('America/Lima'),
            'state' => 'Pendiente'
        ]);

        toastr()->success('Ahora la cotizacion esta en proceso, envia un mensaje al area de Pricing');

        return redirect('/quote/freight/'.$quote->id);
        
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

        return Validator::make($request->all(), [
            'origin' => 'required|string',
            'destination' => 'required|string',
            'load_type' => 'required|string',
            'commodity' => 'required|string',
            'container_type' => 'required_if:lcl_fcl,FCL',
            'ton_kilogram' => 'required_if:lcl_fcl,FCL',
            'packaging_type' => 'required|string',
            'cubage_kgv' => 'required_if:lcl_fcl,LCL',
            'total_weight' => 'required_if:lcl_fcl,LCL',
            'packages' => 'required|string',
            'lcl_fcl' => 'required',
        ]);
    }


    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
    }

}
