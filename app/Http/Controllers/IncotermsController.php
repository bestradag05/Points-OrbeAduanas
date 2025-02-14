<?php

namespace App\Http\Controllers;

use App\Models\Incoterms;
use Illuminate\Http\Request;

class IncotermsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listamos los incoterms

        $incoterms = Incoterms::all();

        $heads = [
            '#',
            'Code',
            'Nombre',
            'Descripcion',
            'Estado',
            'Acciones'
        ];


        return view('incoterms/list-incoterm', compact('incoterms', "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view("incoterms/register-incoterm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Registramos el incoterm

        $this->validateForm($request, null);


        Incoterms::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'state' => 'Activo'
        ]);


       return redirect('incoterms');
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
        $incoterm = Incoterms::findorFail($id);

        return view("incoterms/edit-incoterm", compact('incoterm'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $this->validateForm($request, $id);

        $incoterms = Incoterms::findorFail($id);


        $incoterms->fill($request->all());
        $incoterms->save();

        return redirect('incoterms');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $incoterm = Incoterms::find($id);
        $incoterm->update(['state' => 'Inactivo']);

        return redirect('incoterms')->with('eliminar', 'ok');
    }


    public function validateForm($request, $id){
        $request->validate([
            'code' => 'required|string|unique:incoterms,code,' . $id,
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);
    
    }


}
