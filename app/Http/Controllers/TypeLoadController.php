<?php

namespace App\Http\Controllers;

use App\Models\TypeLoad;
use Illuminate\Http\Request;

class TypeLoadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $type_loads = TypeLoad::all();
        
         $heads = [
             '#',
             'Nombre',
             'Descripcion',
             'Estado',
             'Acciones'
         ];
         
 
         return view("type_load/list-type_load", compact("type_loads", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('type_load.register-type_load');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validateForm($request, null);


        TypeLoad::create([
            'name' => $request->name,
            'description' => $request->description,
            'state' => 'Activo'
        ]);

        return redirect('type_load');
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
        $type_load = TypeLoad::findOrFail($id);

        return view('type_load.edit-type_load', compact('type_load'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $this->validateForm($request, null);

        $type_load = TypeLoad::find($id);
 
         $type_load->fill($request->all());
         $type_load->save();
         
         return redirect('type_load');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type_load = TypeLoad::find($id);
        $type_load->update(['state' => 'Inactivo']);

        return redirect('type_load')->with('eliminar', 'ok');
    }

    public function validateForm($request, $id){
        $request->validate([
            'name' => 'required|string|unique:type_load,name,' . $id,
            'description' => 'nullable|string'
        ]);
    
    }

}
