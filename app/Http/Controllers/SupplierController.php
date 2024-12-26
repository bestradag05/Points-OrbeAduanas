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
          'address' => $request->address,
          'contact_name' => $request->contact_name,
          'contact_number' => $request->contact_number,
          'contact_email' => $request->contact_email,
          'state' => 'Activo',
      ]);


      return redirect('suppliers');
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

        /* $document = CustomerSupplierDocument::find($request->id_document);
        $digits = $document ? $document->number_digits : null; */


        $request->validate([
           /*  'id_document' => 'required|string',
            'document_number' => [
                'required',
                'numeric',
                'unique:suppliers,document_number,' . $id,
                $digits ? 'digits:' . $digits : 'nullable'
            ], */
            'name_businessname' => 'required|string|unique:suppliers,name_businessname,' . $id,
            'address' => 'required|string',
            'contact_name' => 'required|string',
            'contact_number' => 'required|string',
            'contact_email' => 'required|email',
        ]);
    }


}
