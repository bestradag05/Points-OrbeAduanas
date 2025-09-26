<?php

namespace App\Http\Controllers;

use App\Models\Warehouses;
use Illuminate\Http\Request;

class WarehousesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $warehouses = Warehouses::all(); // Trae todos los registros (sin filtro de estado)


        $heads = [
            '#',
            'Ruc',
            'Razon Social',
            'Contacto',
            'Numero',
            'Email',
            'Tipo de almacen',
            'Estado',
            'Acciones'
        ];

        return view('warehouses/list-warehouse', compact('warehouses', "heads"));
    }

    // Formulario de creación
    public function create()
    {
        $warehouses = new Warehouses();

        return view('warehouses/register-warehouse', compact('warehouses'));
    }

    // Guardar nuevo régimen
    public function store(Request $request)
    {
        $this->validateForm($request, null);


        Warehouses::create([
            'ruc' => $request->ruc,
            'name_businessname' => $request->name_businessname,
            'contact_name' => $request->contact_name,
            'contact_number' => $request->contact_number,
            'contact_email' => $request->contact_email,
            'warehouses_type' => $request->warehouses_type,
        ]);


        return redirect()->route('warehouses.index')->with('success', 'Almacen registrado.');
    }

    // Formulario de edición
    public function edit($id)
    {
        $warehouses = Warehouses::findorFail($id);

        return view("warehouses.edit-warehouse", compact('warehouses', 'formMode'));
    }

    // Actualizar régimen
    public function update(Request $request, $id)
    {
        $this->validateForm($request, $id);

        $warehouse = Warehouses::findOrFail($id);

        $warehouse->fill($request->all());
        $warehouse->save();

        return redirect('warehouses');
    }

    // Eliminar régimen
    public function destroy($id)
    {
        $warehouse = Warehouses::find($id);
        $warehouse->update(['state' => 'Inactivo']);

        return redirect('warehouses')->with('eliminar', 'ok');
    }
    public function validateForm($request, $id)
    {
        $request->validate([
            'ruc' => 'required|string|unique:warehouses,ruc,' . $id,
            'name_businessname' => 'required|string',
            'contact_number' => 'nullable|numeric',
            'contact_email' => 'nullable|email',
            'warehouses_type' => 'required|string',

        ]);
    }
}
