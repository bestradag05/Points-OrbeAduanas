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

        // Obtener el primer segmento de la URL (prospects o customers)
        $segment = request()->segment(1);

        // Obtener el ID del personal del usuario autenticado
        $personalId = Auth::user()->personal->id;


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


        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, filtrar por el tipo según el segmento (prospects o customers)
            if ($segment === 'prospects') {
                // Obtener todos los prospectos (sin importar el personal)
                $customers = Customer::with('personal')->where('type', 'prospecto')->get();
                return view("prospect.list-prospect", compact("customers", "heads"));
            } elseif ($segment === 'customer') {
                // Obtener todos los clientes (sin importar el personal)
                $customers = Customer::with('personal')->where('type', 'cliente')->get();
                return view("customer.list-customer", compact("customers", "heads"));
            }
        } else {
            // Si no es Super-Admin, filtrar por el tipo de cliente según el segmento
            if ($segment === 'prospects') {
                // Filtrar prospectos para el personal del usuario autenticado
                $customers = Customer::with('personal')
                    ->where('id_personal', $personalId)
                    ->where('type', 'prospecto')
                    ->get();
                return view("prospect.list-prospect", compact("customers", "heads"));
            } elseif ($segment === 'customer') {
                // Filtrar clientes para el personal del usuario autenticado
                $customers = Customer::with('personal')
                    ->where('id_personal', $personalId)
                    ->where('type', 'cliente')
                    ->get();
                return view("customer.list-customer", compact("customers", "heads"));
            }
        }

        // Si no es ni "prospects" ni "customers", redirigir o manejar el error
        return redirect()->route('home');
    }

    /**bb
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redireccion al formulario para crear cliente
        $segment = request()->segment(1);

        if ($segment === 'prospects') {

            $documents = CustomerSupplierDocument::all();

            return view("prospect/register-prospect", compact('documents'));
        } elseif ($segment === 'customer') {

            $documents = CustomerSupplierDocument::all();
            return view("customer/register-customer", compact('documents'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request, null);
        $segment = request()->segment(1);
        // Guardar un cliente
        Customer::create([
            'id_document' => $request->id_document,
            'document_number' => $request->document_number,
            'name_businessname' => $request->name_businessname,
            'address' => $request->address,
            'contact_name' => $request->contact_name,
            'contact_number' => $request->contact_number,
            'contact_email' => $request->contact_email,
            'type' => $request->type,
            'state' => 'Activo',
            'id_personal' => Auth::user()->personal->id
        ]);


        if ($segment === 'prospects') {

            return redirect('prospects');
        } elseif ($segment === 'customer') {

            return redirect('customer');
        }


        return redirect('home');
    }



    public function consultRuc($ruc)
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


    public function getDataForRuc($document_number)
    {

        $customer = Customer::where('document_number', $document_number)->first();

        if (!$customer) {
            return null;
        }

        return response()->json($customer);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $documentNumber = $request->input('document_number');
        $idDocument = $request->input('id_document');

        // Buscar al cliente según el número de documento y tipo de documento
        $customer = Customer::where('document_number', $documentNumber)
            ->where('id_document', $idDocument)
            ->first();

        if ($customer) {
            return response()->json(['success' => true, 'customer' => $customer]);
        } else {
            return response()->json(['success' => false, 'message' => 'Cliente no encontrado, debe completar los campos.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Redireccion al form de edit

        $segment = request()->segment(1);

        $customer = Customer::find($id);
        $documents = CustomerSupplierDocument::all();

        if ($segment === 'prospects') {
            return view("prospect/edit-prospect", compact('customer', 'documents'));
        } elseif ($segment === 'customer') {
            return view("customer/edit-customer", compact('customer', 'documents'));
        }

        return redirect('home');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Actualizar un cliente

        $this->validateForm($request, $id);
        $segment = request()->segment(1);
        $customer = Customer::find($id);

        $customer->fill($request->all());
        $customer->save();

        if ($segment === 'prospects') {

            return redirect('prospects');
        } elseif ($segment === 'customer') {

            return redirect('customer');
        }


        return redirect('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $segment = request()->segment(1);

        $customer = Customer::find($id);
        $customer->update(['state' => 'INACTIVO']);


        if ($segment === 'prospects') {

            return redirect('prospects')->with('eliminar', 'ok');
        } elseif ($segment === 'customer') {

            return redirect('customer')->with('eliminar', 'ok');
        }


        return redirect('home');

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
