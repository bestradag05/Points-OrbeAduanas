<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::all();

        $heads = [
            '#',
            'Divisa',
            'Abreviatura',
            'Simbolo',
            'Acciones'
        ];

        return view('currencies.list-currencies', compact('currencies', 'heads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('currencies.register-currencies');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Currency::create($request->all());
        return redirect()->route('currencies.index')->with('success', 'Moneda creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $currency = Currency::findOrFail($id);
        return view('currencies.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $currency = Currency::findOrFail($id);
        return view('currencies.edit-currencies', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $currency = Currency::findOrFail($id);

        $currency->update($request->all());
        return redirect()->route('currencies.index')->with('success', 'Moneda actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        return redirect()->route('currencies.index')->with('success', 'Moneda eliminada correctamente.');
    }
}
