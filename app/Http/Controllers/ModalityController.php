<?php

namespace App\Http\Controllers;

use App\Models\Modality;
use Illuminate\Http\Request;

class ModalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listamos los tipo de modalidad

        $modalitys = Modality::all();

        $heads = [
            '#',
            'Nombre',
            'Descripcion',
            'Acciones'
        ];


        return view("modality/list-modality", compact("modalitys", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redireccion al formulario para crear modalidad

        return view("modality/register-modality");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Guardar un tipo de embarque

        $this->validateForm($request, null);

        Modality::create([
            'name' => $request->name,
            'description' => $request->description
        ]);


        return redirect('modality');
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

        $modality = Modality::find($id);

        return view("modality/edit-modality", compact('modality'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Actualizar un tipo de embarque

        $this->validateForm($request, $id);
        $modality = Modality::find($id);

        $modality->fill($request->all());
        $modality->save();

        return redirect('modality');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $modality = Modality::find($id);
        $modality->delete();

        return redirect('modality')->with('eliminar', 'ok');
    }


    public function validateForm($request, $id){
        $request->validate([
            'name' => 'required|string|unique:modality,name,' . $id,
            'description' => 'required|string'
        ]);
    
    }
}
