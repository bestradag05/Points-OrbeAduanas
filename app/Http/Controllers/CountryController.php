<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personalId = Auth::user()->personal->id;
        
        if(Auth::user()->hasRole("Super-Admin")){
            
            $countrys = Country::all();

        }else {
            $countrys = Country::where('state', 'Activo')->get();

        }


        
        $heads = [
            '#',
            'Nombre',
            'Estado',
            'Acciones'
        ];
        

        return view("country/list-country", compact("countrys", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
            //
    
            return view("country/register-country");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         //Registramos el incoterm

         $this->validateForm($request, null);


         Country::create([

             'name' => $request->name,

         ]);
 
 
        return redirect('country');       
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
    public function edit(string $name)
    {
        $country = Country::findorFail($name);

        return view("country/edit-country", compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $country = Country::findorFail($id);


        $country->fill($request->all());
        $country->save();

        return redirect('country');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::find($id);
        $country->update(['state' => 'Inactivo']);


        return redirect('country')->with('eliminar', 'ok');
    }
    
    public function validateForm($request, $id){
        $request->validate([
            
            'name' => 'required|string',
        
        ]);
    
    }
}
