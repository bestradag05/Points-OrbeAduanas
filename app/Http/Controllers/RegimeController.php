<?php

namespace App\Http\Controllers;

use App\Models\Regime;
use Illuminate\Http\Request;

class RegimeController extends Controller
{
    // Lista de regímenes
    public function index()
    {    
     
        $regimes = Regime::all(); // Trae todos los registros (sin filtro de estado)

          
    $heads = [
        '#',
        'Código',
        'Descripción',
        'Estado',
        'Acciones'
    ];
  
    return view('regimes/list-regimes', compact('regimes', "heads"));
}

    // Formulario de creación
    public function create()
    {
        $formMode = 'create'; 
        $regime = new Regime(); 
    
        return view('regimes/register-regimes', compact('formMode', 'regime'));
    }

    // Guardar nuevo régimen
    public function store(Request $request)
    {
        $this->validateForm($request, null);


        Regime::create([

            'code' => $request->code,
            'description' => $request->description
        ]);


        return redirect()->route('regimes.index')->with('success', 'Régimen creado.');
    }

    // Formulario de edición
    public function edit($id)
    {
        $regime = Regime::findorFail($id);
        $formMode = 'edit';

        return view("regimes.edit-regimes", compact('regime','formMode'));
       
    }

    // Actualizar régimen
    public function update(Request $request, $id)
    {
        $this->validateForm($request, $id);

        $regime = Regime::findOrFail($id);

        $regime->fill($request->all());
        $regime->save();

        return redirect('regimes');
    }

    // Eliminar régimen
    public function destroy($id)
    {
        $regime = Regime::find($id);
        $regime->update(['state' => 'Inactivo']); 

        return redirect('regimes')->with('eliminar', 'ok');
    }
    public function validateForm($request, $id)
    {
        $request->validate([

            'code' => 'required|string',
            'description' => 'required',

        ]);
    }
}