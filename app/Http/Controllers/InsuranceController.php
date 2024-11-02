<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insurances = Insurance::with('insurable')->get();

        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Aduana/Flete',
            'Estado',
            'Acciones'
        ];
        
        

        return view("insurances/list-insurance", compact("insurances","heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        // Obtenemos el registro que se va editar

        $insurance = Insurance::with('typeInsurance')->find($id);

        return view('insurances/edit-insurance', compact('insurance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $this->validateForm($request, $id);

        $insurance = Insurance::find($id);

        $dateRegisterFormat = Carbon::createFromFormat('d/m/Y', $request['date'])->toDateString();
        $request['date'] = $dateRegisterFormat;

        $request['state'] = "Generado";

        $insurance->fill($request->all());
        $insurance->save();

        return redirect('insurance');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function getInsurancePending(){

        $insurances = Insurance::with('insurable')->where('state', 'Pendiente')->get();

        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Aduana/Flete',
            'Estado',
            'Acciones'
        ];
        
        

        return view("insurances/pending-list-insurance", compact("insurances","heads"));
    }



    public function validateForm($request, $id)
    {
        $request->validate([
            'certified_number' => 'required|string|unique:insurance,certified_number,' . $id,
            'insured_references' => 'required|string|unique:insurance,insured_references,' . $id,
            'date' => 'string',
        ]);
    }

}
