<?php

namespace App\Http\Controllers;

use App\Models\PackingType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PackingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $packingTypes = PackingType::all();

        $heads = [
            '#',
            'Nombre',
            'Acciones'
        ];

        return view('packing_type.list-packing-type', compact('packingTypes', 'heads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('packing_type.register-packing-type');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request, null);

        PackingType::create([
            'name' => $request->name,
        ]);

        return redirect()->route('packing_type.index')->with('success', 'Tipo de empaque creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PackingType $packingType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackingType $packingType)
    {
        return view('packing_type.edit-packing-type', compact('packingType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PackingType $packingType)
    {
        $this->validateForm($request, $packingType->id);

        $packingType->update([
            'name' => $request->name,
        ]);

        return redirect()->route('packing_type.index')->with('success', 'Tipo de empaque actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackingType $packingType)
    {
        $packingType->delete();
        return redirect()->route('packing_type.index')->with('success', 'Tipo de empaque eliminado correctamente.');
    }

    public function validateForm($request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('packing_types', 'name')
                    ->ignore($id) // ignora el actual en caso de update
                    ->whereNull('deleted_at'),
            ],
        ]);
    }
}
