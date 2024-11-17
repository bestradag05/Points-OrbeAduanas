<?php

namespace App\Http\Controllers;

use App\Models\CustomerSupplierDocument;
use Illuminate\Http\Request;

class CustomerSupplierDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = CustomerSupplierDocument::all();

        $heads = [
            '#',
            'Nombre',
            'Numero de Digitos',
            'Estado',
            'Acciones'
        ];

        return view("customer_supplier_documents/list-customer-supplier-document", compact("documents", "heads"));
    }

   /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("customer_supplier_documents/register-customer-supplier-document");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request, null);

        CustomerSupplierDocument::create([
            'name' => $request->name,
            'number_digits' => $request->number_digits,
            'state' => 'Activo'
        ]);

        return redirect('customer_supplier_document');
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
        $customer_supplier_document = CustomerSupplierDocument::findOrFail($id);

        return view("customer_supplier_documents/edit-customer-supplier-document", compact('customer_supplier_document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $is_document = CustomerSupplierDocument::where("id", "<>", $id)->where("name", $request->name)->first();
        

        if ($is_document) {

            return redirect()->back()->withErrors(['name' => 'Ya se registro este documento.'])->withInput();
        }

    


        $personal_document = CustomerSupplierDocument::findOrFail($id);



        $personal_document->update($request->all());

        return redirect('customer_supplier_document');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $personal_document = CustomerSupplierDocument::find($id);
        $personal_document->update(['state' => 'Inactivo']);

        return redirect('customer_supplier_document')->with('eliminar', 'ok');
    }


    public function validateForm($request, $id)
    {


        $request->validate([
            'name' => 'required|string',
            'number_digits' => 'required|string'

        ]);
    }
}
