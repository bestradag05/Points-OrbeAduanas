<?php

namespace App\Http\Controllers;

use App\Models\Concept;
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

        $concepts = Concept::all()->load('typeService', 'typeShipment');

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
        // Validar los datos del formulario
        $this->validateForm($request, null);

        // Verificar si el radio button "Sí" está seleccionado
        if ($request->allServiceCheck == 1) {
            $typeShipments = TypeShipment::all();
            $typeServices = TypeService::all();

            // Verificar si ya existe alguna combinación de nombre, tipo de embarque y tipo de servicio
            foreach ($typeShipments as $typeShipment) {
                foreach ($typeServices as $typeService) {
                    $existingConcept = Concept::where('name', $request->name)
                        ->where('id_type_shipment', $typeShipment->id)
                        ->where('id_type_service', $typeService->id)
                        ->first();

                    if ($existingConcept) {
                        return back()->with('error', 'Este concepto ya existe para esta combinación de servicio y embarque.');
                    }

                    // Crear el concepto para cada combinación si no existe
                    Concept::create([
                        'name' => $request->name,
                        'id_type_shipment' => $typeShipment->id,
                        'id_type_service' => $typeService->id
                    ]);
                }
            }
        } else {
            // Verificar si el concepto con el mismo nombre y combinación ya existe
            $existingConcept = Concept::where('name', $request->name)
                ->where('id_type_shipment', $request->id_type_shipment)
                ->where('id_type_service', $request->id_type_service)
                ->first();

            if ($existingConcept) {
                return redirect()->back()->with('error', 'Este concepto ya existe para esta combinación de servicio y embarque.');
            }

            // Si no existe, guardar el concepto
            Concept::create([
                'name' => $request->name,
                'id_type_shipment' => $request->id_type_shipment,
                'id_type_service' => $request->id_type_service
            ]);
        }

        // Redirigir a la lista de conceptos
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
        $concept = Concept::find($id);

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
        $concept = Concept::find($id);

        $concept->fill($request->all());
        $concept->save();

        return redirect('concepts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $concept = Concept::find($id);
        $concept->delete();

        return redirect('concepts')->with('eliminar', 'ok');
    }


    public function validateForm($request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'id_type_shipment' => 'required_if:allServiceCheck,0',
            'id_type_service' => 'required_if:allServiceCheck,0',
        ]);
    }
}
