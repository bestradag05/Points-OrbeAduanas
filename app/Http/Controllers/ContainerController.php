<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\TypeContainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContainerController extends Controller
{
    // Lista de contenedores
    public function index()
    {
        $personalId = Auth::user()->personal->id;

        if (Auth::user()->hasRole("Super-Admin")) {

            $containers = Container::all();
        } else {
            $containers = Container::where('state', 'Activo')->get();
        }

        $heads = [
            '#',
            'Nombre',
            'Tipo Contenedor',
            'Descripción',
            'Longitud (m)',
            'Anchura (m)',
            'Altura (m)',
            'Volumen (m³)',
            'Carga Máx (kg)',
            'Acciones'
        ];

        return view('containers/list-containers', compact('containers', 'heads'));
    }

    // Formulario de creación
    public function create()
    {
        $formMode = 'create';
        $container = new Container();
        $typeContainers = TypeContainer::all(); // Para el dropdown de tipos

        return view('containers/register-containers', compact('formMode', 'container', 'typeContainers'));
    }

    // Guardar nuevo contenedor
    public function store(Request $request)
    {
        $this->validateForm($request, null);

        Container::create([
            'name' => $request->nombre,
            'id_type_container' => $request->id_type_container,
            'description' => $request->descripcion,
            'length' => $request->longitud,
            'width' => $request->anchura,
            'height' => $request->altura,
            'max_load' => $request->carga_max
        ]);

        return redirect()->route('containers.index')->with('success', 'Contenedor creado.');
    }

    // Formulario de edición
    public function edit($id)
    {
        $container = Container::findOrFail($id);
        $formMode = 'edit';
        $typeContainers = TypeContainer::all(); // Para el dropdown

        return view("containers.edit-containers", compact('container', 'formMode', 'typeContainers'));
    }

    // Actualizar contenedor
    public function update(Request $request, $id)
    {
        $this->validateForm($request, $id);

        $container = Container::findOrFail($id);
        $container->update($request->all());

        return redirect('containers')->with('success', 'Contenedor actualizado.');
    }

    // Eliminar/Desactivar contenedor
    public function destroy($id)
    {
        $container = Container::find($id);
        
        // Si usas estado (como en RegimeController):
        $container->update(['state' => 'Inactivo']);
        
        // Si prefieres eliminar físicamente:
        // $container->delete();

        return redirect('containers')->with('eliminar', 'ok');
    }

    // Validación centralizada
    private function validateForm(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_type_container' => 'required|exists:type_containers,id',
            'description' => 'nullable|string',
            'length' => 'required|numeric|min:0.01',
            'width' => 'required|numeric|min:0.01',
            'height' => 'required|numeric|min:0.01',
            'max_load' => 'required|numeric|min:0'
        ]);
    }
}