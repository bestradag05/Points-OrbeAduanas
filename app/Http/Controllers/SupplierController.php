<?php

namespace App\Http\Controllers;

use App\Models\CustomerSupplierDocument;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listamos los clientes

        // Obtener el ID del personal del usuario autenticado
        $suppliers = Supplier::all();

        $heads = [
            '#',
            'Razon Social / Nombre',
            'Nombre de Contacto',
            'Numero de Contacto',
            'Correo de Contacto',
            'Area',
            'Tipo de proveedor',
            'Tipo',
            'Documento',
            'Dirección',
            'País',
            'Ciudad',
            'Estado',
            'Acciones'
        ];


        return view("supplier/list-supplier", compact("suppliers", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documents = CustomerSupplierDocument::all();

        return view('supplier.register-supplier', compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Guardar un cliente

        $this->validateForm($request, null);

        Supplier::create([
            /* 'id_document' => $request->id_document,
          'document_number' => $request->document_number, */
            'name_businessname' => $request->name_businessname,
            'area_type'         => $request->area_type,
            'provider_type'     => $request->provider_type,
            'address'           => $request->address,
            'contact_name'      => $request->contact_name,
            'contact_number'    => $request->contact_number,
            'contact_email'     => $request->contact_email,
            'document_number'   => $request->document_number,
            'document_type'     => $request->document_type,
            'cargo_type'        => $request->cargo_type,
            'unit'              => $request->unit,
            'country'           => $request->country,
            'city'              => $request->city,
            'state'             => 'Activo',
        ]);

        return redirect('suppliers')->with('success', 'Proveedor registrado exitosamente.');
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
        $documents = CustomerSupplierDocument::all();
        $supplier = Supplier::findOrFail($id);

        return view('supplier.edit-supplier', compact('supplier', 'documents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);


        $exist_name = Supplier::where("id", "<>", $id)->where("name_businessname", $request->name_businessname)->first();

        if ($exist_name) {

            return redirect()->back()->withErrors(['name_businessname' => 'Ya existe un proovedor con este nombre registrado.'])->withInput();
        }


        $supplier = Supplier::findOrFail($id);



        $supplier->update($request->all());


        return redirect("suppliers");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::find($id);
        $supplier->update(['state' => 'Inactivo']);

        return redirect('suppliers')->with('eliminar', 'ok');
    }

    public function validateForm($request, $id)
    {

        $request->validate([

            'name_businessname' => 'required|string|unique:suppliers,name_businessname,' . $id,
            'area_type' => 'required|in:comercial,transporte,pricing',
            'provider_type' => 'nullable|in:TRANSPORTISTA,NAVIERA,AEROLINEA,AGENTE DE CARGA,COMERCIAL',
            'address' => 'required|string',
            'contact_name' => 'required|string',
            'contact_number' => 'required|string',
            'contact_email' => 'required|email',
            'document_number' => 'nullable|string',
            'document_type' => 'nullable|string',
            'cargo_type' => 'nullable|string',
            'unit' => 'nullable|string',
            'country' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
        ]);
    }
}
