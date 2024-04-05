<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use App\Models\Customer;
use App\Models\Modality;
use App\Models\TypeShipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Listar aduanas

        $customs = Custom::all();
       

        $heads = [
            '#',
            'N° Operacion',
            'N° de orden',
            'N° de Dam',
            'Fecha de Registro',
            'Valor Cif',
            'Canal',
            'N° de BL',
            'Fecha de reguralizacion',
            'Estado',
            'Acciones'
        ];
        

        return view("custom/list-custom", compact("customs","heads"));
    }

    public function getCustomPending(){

        dd('Llego aqui pending');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redireccion al formulario para crear una aduana
        dd('Llego aqui');

        $customers= Customer::all();
        $type_shipments = TypeShipment::all();
        $modalitys = Modality::all();

        return view("custom/register-custom", compact('customers', 'type_shipments', 'modalitys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request, null);

        Custom::create([
            'ruc' => $request->ruc,
            'name_businessname' => $request->name_businessname,
            'contact_name' => $request->contact_name,
            'contact_number' => $request->contact_number,
            'contact_email' => $request->contact_email,
            'id_user' => Auth::user()->id
        ]);

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function validateForm($request, $id){
        $request->validate([
            'nro_orde' => 'required|string|unique:customs,nro_orde,' . $id,
            'ruc' => 'required|string|unique:customs,ruc,' . $id,
            'nro_dam' => 'string|unique:customs,nro_dam,' . $id,
            'regime' => 'string|unique:customs,nro_dam,' . $id,
            'id_type_shipment' => 'required',
            'id_modality'=> 'required',
            'contact_email' => 'required|email',
        ]);
    
    }
}
