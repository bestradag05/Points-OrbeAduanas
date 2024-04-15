<?php

namespace App\Http\Controllers;

use App\Models\Concepts;
use App\Models\TypeService;
use App\Models\TypeShipment;
use Illuminate\Http\Request;

class ConceptsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listamos los conceptos

        $concepts = Concepts::all()->load('typeService', 'typeShipment');

        $heads = [
            '#',
            'Concepto',
            'Tipo de carga',
            'Tipo de Servicio',
            'Acciones'
        ];


        return view("concepts/list-concepts", compact("concepts", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Redireccion al formulario para crear un concepto

         $type_services = TypeService::all();
         $type_shipments = TypeShipment::all();


         return view("concepts/register-concepts", compact('type_services', 'type_shipments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Guardar el concepto

        $this->validateForm($request, null);

        Concepts::create([
            'name' => $request->name,
            'id_type_shipment' => $request->id_type_shipment,
            'id_type_service' => $request->id_type_service
        ]);

        return redirect('concepts');

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
        $concept = Concepts::find($id);

        $type_services = TypeService::all();
        $type_shipments = TypeShipment::all();

        return view("concepts/edit-concepts", compact('concept', 'type_services', 'type_shipments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        
        $this->validateForm($request, $id);
        $concept = Concepts::find($id);

        $concept->fill($request->all());
        $concept->save();

        return redirect('concepts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $concept = Concepts::find($id);
        $concept->delete();

        return redirect('concepts')->with('eliminar', 'ok');
    }


    public function validateForm($request, $id){
        $request->validate([
            'name' => 'required|string',
            'id_type_shipment' => 'required',
            'id_type_service' => 'required',
        ]);
    
    }
}
