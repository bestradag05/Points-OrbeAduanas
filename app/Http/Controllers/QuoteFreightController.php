<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuoteFreightController extends Controller
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
        //
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
}
