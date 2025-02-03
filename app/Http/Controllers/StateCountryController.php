<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\StateCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StateCountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personalId = Auth::user()->personal->id;

        if (Auth::user()->hasRole("Super-Admin")) {

            $statecountrys = StateCountry::all();
        } else {
            $statecountrys = StateCountry::where('state', 'Activo')->get();
        }



        $heads = [
            '#',
            'Nombre',
            'Pais',
            'Estado',
            'Acciones'
        ];


        return view("state_country/list-state-country", compact("statecountrys", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countrys = Country::all();


        return view("state_country/register-state-country", compact('countrys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Registramos el incoterm

        $this->validateForm($request, null);


        StateCountry::create([

            'name' => $request->name,
            'id_country' => $request->id_country

        ]);


        return redirect()->route('state_country.index'); ;
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
  
        $stateCountry = StateCountry::findorFail($id);
        $countrys = Country::all();

        return view("state_country/edit-state-country", compact('stateCountry','countrys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $stateCountry = StateCountry::findorFail($id);


        $stateCountry->fill($request->all());
        $stateCountry->save();

        return redirect('state_country');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stateCountry = StateCountry::find($id);
        $stateCountry->update(['state' => 'Inactivo']);


        return redirect()->route('state_country.index')->with('eliminar', 'ok');
    }

    public function validateForm($request, $id)
    {
        $request->validate([

            'name' => 'required|string',
            'id_country' => 'required',

        ]);
    }
}
