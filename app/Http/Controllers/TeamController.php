<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Team;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $personalId = Auth::user()->personal->id;

        if (Auth::user()->hasRole("Super-Admin")) {
            $teams = Team::all();
        } else {
            $teams = Team::where('state', 'Activo')->get();
        }

        $heads = [
            '#',
            'Nombre',
            'Estado',
            'Acciones'
        ];

        return view("teams/list-team", compact("teams", "heads"));
    }

    public function create()
    {
        $areas = Area::where('state', 'Activo')->get();

        return view("teams/register-team", compact('areas'));
    }
    
    public function store(Request $request)
    {
        $this->validateForm($request, null);

        $team = Team::create([
            'name' => $request->name,   
        ]);

        if ($request->has('areas')) {
            $team->areas()->sync($request->areas);
        }

        return redirect('teams');
    }

    public function edit(string $id)
    {
        $team = Team::findOrFail($id);
        $areas = Area::where('state', 'Activo')->get();

        return view("teams/edit-team", compact('team'));
    }

    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $team = Team::findOrFail($id);
        $team->fill($request->all());
        $team->save();

        if ($request->has('areas')) {
            $team->areas()->sync($request->areas);
        }

        return redirect('teams');
    }

    public function destroy(string $id)
    {
        $team = Team::findOrFail($id);
        $team->update(['state' => 'Inactivo']);

        return redirect('teams')->with('eliminar', 'ok');
    }

    private function validateForm($request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'areas' => 'nullable|array',
            'areas.*' => 'exists:areas,id',
        ]);
    }
}
