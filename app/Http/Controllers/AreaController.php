<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    public function index()
    {
        $personalId = Auth::user()->personal->id;

        if (Auth::user()->hasRole("Super-Admin")) {
            $areas = Area::all();
        } else {
            $areas = Area::where('state', 'Activo')->get();
        }

        $heads = [
            '#',
            'Nombre',
            'Estado',
            'Acciones'
        ];

        return view("areas/list-area", compact("areas", "heads"));
    }

    public function create()
    {
        return view("areas/register-area");
    }

    public function store(Request $request)
    {
        $this->validateForm($request, null);

        Area::create([
            'name' => $request->name,
        ]);

        return redirect('areas');
    }

    public function edit(string $id)
    {
        $area = Area::findOrFail($id);
        return view("areas/edit-area", compact('area'));
    }

    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $area = Area::findOrFail($id);
        $area->fill($request->all());
        $area->save();

        return redirect('areas');
    }

    public function destroy(string $id)
    {
        $area = Area::findOrFail($id);
        $area->update(['state' => 'Inactivo']);

        return redirect('areas')->with('eliminar', 'ok');
    }

    private function validateForm($request, $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
    }
}
