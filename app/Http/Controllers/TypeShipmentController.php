<?php

namespace App\Http\Controllers;

use App\Models\TypeShipment;
use Illuminate\Http\Request;

class TypeShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Listamos los tipo de embarque

         $type_shipments = TypeShipment::all();
        
         $heads = [
             '#',
             'Nombre',
             'Descripcion',
             'Estado',
             'Acciones'
         ];
         
 
         return view("type_shipment/list-type_shipment", compact("type_shipments", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redireccion al formulario para crear tipo de embarque

        return view("type_shipment/register-type_shipment");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Guardar un tipo de embarque

         $this->validateForm($request, null);

         TypeShipment::create([
             'name' => $request->name,
             'description' => $request->description
         ]);
 
 
        return redirect('type_shipment');
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
        // Redireccion al form de edit

        $type_shipment = TypeShipment::find($id);

        return view("type_shipment/edit-type_shipment", compact('type_shipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // Actualizar un tipo de embarque

         $this->validateForm($request, $id);
         $type_shipment = TypeShipment::find($id);
 
         $type_shipment->fill($request->all());
         $type_shipment->save();
         
         return redirect('type_shipment');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type_shipment = TypeShipment::find($id);
        $type_shipment->update(['status' => 'Inactivo']);

        return redirect('type_shipment')->with('eliminar', 'ok');
    }


    public function validateForm($request, $id){
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);
    
    }
}
