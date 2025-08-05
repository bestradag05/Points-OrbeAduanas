<?php

namespace App\Http\Controllers;

use App\Models\TypeInsurance;
use Illuminate\Http\Request;

class TypeInsuranceController extends Controller
{
    public function index()
    {
        $type_insurances = TypeInsurance::all();
        
         $heads = [
             '#',
             'Nombre',
             'Estado',
             'Acciones'
         ];
         
 
         return view("insurances/type_insurance/list-type_insurance", compact("type_insurances", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('insurances/type_insurance.register-type_insurance');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validateForm($request, null);


        TypeInsurance::create([
            'name' => $request->name,
            'state' => 'Activo'
        ]);

        return redirect('type_insurance');
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
        $type_insurance = TypeInsurance::findOrFail($id);

        return view('insurances/type_insurance.edit-type_insurance', compact('type_insurance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $this->validateForm($request, $id);

        $type_insurance = TypeInsurance::find($id);
 
         $type_insurance->fill($request->all());
         $type_insurance->save();
         
         return redirect('type_insurance');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type_insurance = TypeInsurance::find($id);
        $type_insurance->update(['state' => 'Inactivo']);

        return redirect('type_insurance')->with('eliminar', 'ok');
    }

    public function validateForm($request, $id){
        $request->validate([
            'name' => 'required|string|unique:type_insurance,name,' . $id,
        ]);
    
    }
}
