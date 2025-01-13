<?php

namespace App\Http\Controllers;

use App\Models\MessageQuoteFreight;
use App\Models\QuoteFreight;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MessageQuoteFreightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validateForm($request, null);

        $messageQuoteFreight = MessageQuoteFreight::create([
            'quote_freight_id' => $request->quote_id,
            'sender_id' => Auth::user()->id,
            'message' => $request->message
        ]);


        return redirect('/quote/freight/'.$request->quote_id);
        

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
 
        $quote = QuoteFreight::findOrFail($id);
  
        $showModal = session('showModal', false);


         //Obtenemos los documentos si es que existen
         $folderPath = "quote_freight/{$quote->nro_quote}";
         $files = collect(Storage::disk('public')->files($folderPath))->map(function ($file) {
             return [
                 'name' => basename($file), // Nombre del archivo
                 'size' => Storage::disk('public')->size($file), // Tamaño del archivo
                 'url' => asset('storage/' . $file), // URL del archivo
             ];
         });

        return view('freight.quote.edit-quote', compact('quote', 'files'))->with('showModal', $showModal);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $quote = QuoteFreight::findOrFail($id);

        $quote->update($request->all());

        if ($request->uploaded_files) {

            $nroOperationFolder = "quote_freight/$quote->nro_quote";
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


        return redirect('/quote/freight/'. $quote->id);

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
            'message' => 'required|string',
        ]);
    }
}
