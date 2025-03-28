<?php

namespace App\Http\Controllers;

use App\Models\TypeContainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeContainerController extends Controller
{
    // Lista de tipos de contenedores
    public function index()
    {
        $personalId = Auth::user()->personal->id;

        if (Auth::user()->hasRole("Super-Admin")) {

            $typeContainers = TypeContainer::all();
        } else {
            $typeContainers = TypeContainer::where('state', 'Activo')->get();
        }
        $heads = [
            '#',
            'Nombre',
            'Descripción',
            'Estado',
            'Acciones'
        ];

        return view('type_containers/list-type-containers', compact('typeContainers', 'heads'));
    }

    // Formulario de creación
    public function create()
    {
        $formMode = 'create';
        $typeContainer = new TypeContainer();

        return view('type_containers/register-type-containers', compact('formMode', 'typeContainer'));
    }

    // Guardar nuevo tipo
    public function store(Request $request)
    {
        $this->validateForm($request, null);
        /* dd($request->all()); */

        TypeContainer::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect('type_containers');
    }

    // Formulario de edición
    public function edit($id)
    {
        $typeContainer = TypeContainer::findOrFail($id);
        $formMode = 'edit';

        return view("type_containers.edit-type-containers", compact('typeContainer', 'formMode'));
    }

    // Actualizar tipo
    public function update(Request $request, $id)
    {
        $this->validateForm($request, $id);

        $typeContainer = TypeContainer::findOrFail($id);
        $typeContainer->update($request->all());

        return redirect('type_containers')->with('success', 'Tipo actualizado.');
    }

    // Desactivar tipo
    public function destroy($id)
    {
        $typeContainer = TypeContainer::findOrFail($id);
        $typeContainer->update(['state' => 'Inactivo']);

        return redirect('type_containers')->with('eliminar', 'ok');

    }

    // Validación centralizada
    private function validateForm(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);
    }
}
