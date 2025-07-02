<?php

namespace App\Http\Controllers;

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
        return view("teams/register-team");
    }

    public function store(Request $request)
    {
        $this->validateForm($request, null);

        Team::create([
            'name' => $request->name,
        ]);

        return redirect('teams');
    }

    public function edit(string $id)
    {
        $team = Team::findOrFail($id);
        return view("teams/edit-team", compact('team'));
    }

    public function update(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $team = Team::findOrFail($id);
        $team->fill($request->all());
        $team->save();

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
        ]);
    }
}
