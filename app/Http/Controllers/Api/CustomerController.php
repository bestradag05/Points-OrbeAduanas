<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->search;

        $customers = Customer::all();

        return response()->json([
            "customers" => $customers->map(function($customer) {
                return [
                    'id' => $customer->id,
                   'document_number' => $customer->document_number,
                   'name_businessname' => $customer->name_businessname,
                   'address' => $customer->address,
                   'contact_name' => $customer->contact_name,
                   'contact_number' => $customer->contact_number,
                   'contact_email' => $customer->contact_email,
                   'state' => $customer->state,
                   'id_document' => $customer->id_document,
                ];
            }),
        ]);
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
        
        $exist_customer = Customer::where("document_number", $request->document_number)->first();

        if($exist_customer){
            return response()->json([
                "message" => 403,
                "message_text" => "El cliente ya existe"
            ]);
        }

        Customer::create([
            'id_document' => $request->id_document,
            'document_number' => $request->document_number,
            'name_businessname' => $request->name_businessname,
            'address' => $request->address,
            'contact_name' => $request->contact_name,
            'contact_number' => $request->contact_number,
            'contact_email' => $request->contact_email,
            'id_user' => $request->id_user,
            'state' => 'Activo'
        ]);

        return response()->json([
            "message" => "El cliente se registro con exito",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json([
            "id" => $customer->id,
            "id_document" => $customer->id_document,
            "document_number" => $customer->document_number,
            "name_businessname" => $customer->name_businessname,
            "address" => $customer->address,
            "contact_name" => $customer->contact_name,
            "contact_number" => $customer->contact_number,
            "contact_email" => $customer->contact_email,

        ]);
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

        $exist_customer = Customer::where("id", "<>", $id)->where("document_number", $request->document_number)->first();

        if($exist_customer){
            return response()->json([
                "message" => 403,
                "message_text" => "El cliente ya existe"
            ]);
        }

        $customer = Customer::findOrFail($id);

      

        $customer->update($request->all());


        return response()->json([
            "message" => "Cliente actualizado"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth('api')->user()->can('delete_rol')){
            return response()->json(["message"=>"EL USUARIO NO ESTA AUTORIZADO"],403);
        }

        $customer = Customer::findOrFail($id);

        $customer->update(['state' => 'Inactivo']);

        return response()->json([
            "message"=> 200,
            "state" => $customer->state
        ]);
    }
}
