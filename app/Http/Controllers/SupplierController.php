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

        $userRole = auth()->user()->roles->first()->name;


        if ($userRole === 'Super-Admin') {

            $suppliers = Supplier::all();
        } else {

            // Obtener el ID del personal del usuario autenticado
            $suppliers = Supplier::where('area_type', $this->getAreaTypeByRole($userRole))->get();
        }

        $heads = [
            '#',
            'Razon Social / Nombre',
            'Nombre de Contacto',
            'Numero de Contacto',
            'Correo de Contacto',
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


    private function getAreaTypeByRole($role)
    {
        // Mapear los roles a los valores de area_type
        switch ($role) {
            case 'Pricing':
                return 'pricing';
            case 'Transporte':
                return 'transporte';
            case 'Asesor Comercial':
                return 'comercial';
            default:
                return ''; // Si el rol no coincide con los casos anteriores, devolver un valor vacío o manejar el caso
        }
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
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Determinar el área automáticamente por el rol
        $area = null;
        if ($user->hasRole('Transporte')) {
            $area = 'transporte';
        } elseif ($user->hasRole('Comercial')) {
            $area = 'comercial';
        } elseif ($user->hasRole('Pricing')) {
            $area = 'pricing';
        } elseif ($user->hasRole('Super-Admin')) {
            // Si quieres permitirle al Super-Admin elegir manualmente
            $area = $request->area_type ?? null;
        }

        // Validación (puedes extraerla a un método aparte si gustas)
        $this->validateForm($request, null);

        // Registro del proveedor con área autoasignada
        Supplier::create([
            'name_businessname' => $request->name_businessname,
            'area_type'         => $area,
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

    public function storeSuppliertAsync(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Determinar el área automáticamente por el rol
        $area = null;
        if ($user->hasRole('Transporte')) {
            $area = 'transporte';
        } elseif ($user->hasRole('Comercial')) {
            $area = 'comercial';
        } elseif ($user->hasRole('Pricing')) {
            $area = 'pricing';
        } elseif ($user->hasRole('Super-Admin')) {
            // Si quieres permitirle al Super-Admin elegir manualmente
            $area = $request->area_type ?? null;
        }

        // Validación (puedes extraerla a un método aparte si gustas)
        $this->validateForm($request, null);

        $existingSupplier = Supplier::where('name_businessname', $request->name_businessname)->first();

        if ($existingSupplier) {
            // Si el concepto ya existe, retornar un error
            return response()->json(['error' => 'Este agente ya se encuentra registrado.'], 400);
        }


        // Registro del proveedor con área autoasignada
        $supplier = Supplier::create([
            'name_businessname' => $request->name_businessname,
            'area_type'         => $area,
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

        // Redirigir a la lista de conceptos
        return response()->json([
            'id' => $supplier->id,
            'name' => $supplier->name_businessname,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $nameBusinessname)
    {
        // Buscar al cliente según el número de documento y tipo de documento
        $supplier = Supplier::where('name_businessname', $nameBusinessname)
            ->where('area_type', 'comercial')
            ->first();

        if ($supplier) {
            return response()->json(['success' => true, 'supplier' => $supplier]);
        } else {
            return response()->json(['success' => false, 'message' => 'Proveedor no encontrado, debe completar los campos.']);
        }
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
            /* 'area_type' => 'required|in:comercial,transporte,pricing', */
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
