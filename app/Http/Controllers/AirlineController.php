<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airlines = Airline::all();

        $heads = [
            '#',
            'Nombre',
            'contacto',
            'cellphone',
            'email',
            'Estado',
            'Acciones'
        ];

        return view('airline.list-airline', compact('airlines', 'heads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('airline.register-airline');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request, null);

        Airline::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
        ]);

        return redirect()->route('airline.index')->with('success', 'Aerolínea creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Airline $airline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airline $airline)
    {
        return view('airline.edit-airline', compact('airline'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Airline $airline)
    {
        $this->validateForm($request, $airline->id);

        $airline->update([
            'name' => $request->name,
            'contact' => $request->contact,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
        ]);

        return redirect()->route('airline.index')->with('success', 'Aerolínea actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airline $airline)
    {
        $airline->delete();
        return redirect()->route('airline.index')->with('success', 'Aerolínea eliminado correctamente.');
    }

    public function validateForm($request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('airlines', 'name')
                    ->ignore($id) // ignora el actual en caso de update
                    ->whereNull('deleted_at'),
            ],
            'contact' => 'nullable|string',
            'cellphone' => 'nullable|string',
            'email' => 'nullable|string'
        ]);
    }
}
