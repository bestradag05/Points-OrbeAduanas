<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $commissions = Commission::all();
        $heads = [
            '#',
            'Nombre',
            'Monto',
            'Descripción',
            'Acciones'
        ];
        return view('commissions.fixed.list-commission', compact('commissions', 'heads'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('commissions.fixed.register-commission');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'default_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);


        Commission::create($data);

        return redirect()->route('commissions.fixed.index')->with('success', 'Comisión creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('commissions.fixed.show', compact('commission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $commission = Commission::findorFail($id);

        return view('commissions.fixed.edit-commission', compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $commission = Commission::findorFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'default_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $commission->update($data);

        return redirect()->route('commissions.fixed.index')->with('success', 'Comisión actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $commission = Commission::findorFail($id);
        $commission->delete();

        return redirect()->route('commissions.fixed.index')->with('success', 'Comisión eliminada correctamente.');
    }
}
