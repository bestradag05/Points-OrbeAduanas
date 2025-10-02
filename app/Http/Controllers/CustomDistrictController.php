<?php

namespace App\Http\Controllers;

use App\Models\CustomDistrict;
use Illuminate\Http\Request;

class CustomDistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listamos los tipo de embarque

        $customsDistricts = CustomDistrict::all();

        $heads = [
            '#',
            'Code',
            'Nombre',
            'Descripcion',
            'Estado',
            'Acciones'
        ];


        return view("custom_districts/list-custom_district", compact("customsDistricts", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redireccion al formulario para crear tipo de embarque

        return view("custom_districts/register-custom_district");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Guardar un tipo de embarque

        $this->validateForm($request, null);

        CustomDistrict::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description
        ]);


        return redirect('customs_districts');
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

        $customDistrict = CustomDistrict::find($id);

        return view("custom_districts/edit-custom_district", compact('customDistrict'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Actualizar un tipo de embarque

        $this->validateForm($request, $id);
        $type_shipment = CustomDistrict::find($id);

        $type_shipment->fill($request->all());
        $type_shipment->save();

        return redirect('customs_districts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customDistrict = CustomDistrict::find($id);
        $customDistrict->update(['status' => 'Inactivo']);

        return redirect('customs_districts')->with('eliminar', 'ok');
    }


    public function validateForm($request, $id)
    {
        $request->validate([
            'code' => 'required|numeric|unique:customs_districts,code,' . $id,
            'description' => 'required|string'
        ]);
    }
}
