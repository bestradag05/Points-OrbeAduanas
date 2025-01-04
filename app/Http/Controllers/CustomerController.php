<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerSupplierDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listamos los clientes

        // Obtener el ID del personal del usuario autenticado
        $personalId = Auth::user()->personal->id;

        dd($personalId);
        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin') || Auth::user()->can('customar.all')) {
            // Si es Super-Admin, obtener todos los clientes
            $customers = Customer::with('personal')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $customers = Customer::with('personal')
                ->where('id_personal', $personalId)
                ->get();
        }

        $heads = [
            '#',
            'Tipo de Documento',
            'Numero de Documento',
            'Razon Social / Nombre',
            'Nombre de Contacto',
            'Numero de Contacto',
            'Correo de Contacto',
            'Vendedor',
            'Estado',
            'Acciones'
        ];


        return view("customer/list-customer", compact("customers", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redireccion al formulario para crear cliente

        $documents = CustomerSupplierDocument::all();

        return view("customer/register-customer", compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Guardar un cliente

        $this->validateForm($request, null);


        Customer::create([
            'id_document' => $request->id_document,
            'document_number' => $request->document_number,
            'name_businessname' => $request->name_businessname,
            'address' => $request->address,
            'contact_name' => $request->contact_name,
            'contact_number' => $request->contact_number,
            'contact_email' => $request->contact_email,
            'state' => 'Activo',
            'id_personal' => Auth::user()->personal->id
        ]);


        return redirect('customer');
    }



    public function obtenerDatosRuc($ruc)
    {
        try {
            $url = "https://ww1.sunat.gob.pe/ol-ti-itfisdenreg/itfisdenreg.htm?accion=obtenerDatosRuc&nroRuc=" . $ruc;
            $response = Http::get($url);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'No se pudo obtener los datos del RUC'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un problema con la solicitud: ' . $e->getMessage()], 500);
        }
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
        // Redireccion al form de edit

        $customer = Customer::find($id);
        $documents = CustomerSupplierDocument::all();

        return view("customer/edit-customer", compact('customer', 'documents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Actualizar un cliente

        $this->validateForm($request, $id);
        $customer = Customer::find($id);

        $customer->fill($request->all());
        $customer->save();

        return redirect('customer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $customer = Customer::find($id);
        $customer->update(['state' => 'INACTIVO']);

        return redirect('customer')->with('eliminar', 'ok');
    }


    public function validateForm($request, $id)
    {
        $document = CustomerSupplierDocument::find($request->id_document);
        $digits = $document ? $document->number_digits : null;


        $request->validate([
            'id_document' => 'required|string',
            'document_number' => [
                'required',
                'numeric',
                'unique:customer,document_number,' . $id,
                $digits ? 'digits:' . $digits : 'nullable'
            ],
            'name_businessname' => 'required|string|unique:customer,name_businessname,' . $id,
            'address' => 'required|string',
            'contact_name' => 'required|string',
            'contact_number' => 'required|string',
            'contact_email' => 'required|email',
        ]);
    }
}
