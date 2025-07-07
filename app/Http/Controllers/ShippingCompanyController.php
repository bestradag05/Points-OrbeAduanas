<?php

namespace App\Http\Controllers;

use App\Models\ShippingCompany;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShippingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingCompanies = ShippingCompany::all();

        $heads = [
            '#',
            'Nombre',
            'contacto',
            'cellphone',
            'email',
            'Estado',
            'Acciones'
        ];

        return view('shipping_company.list-shipping-company', compact('shippingCompanies', 'heads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shipping_company.register-shipping-company');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request, null);

        ShippingCompany::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
        ]);

        return redirect()->route('shipping_company.index')->with('success', 'Naviera creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingCompany $shippingCompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingCompany $shippingCompany)
    {
        return view('shipping_company.edit-shipping-company', compact('shippingCompany'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingCompany $shippingCompany)
    {
        $this->validateForm($request, $shippingCompany->id);

        $shippingCompany->update([
            'name' => $request->name,
            'contact' => $request->contact,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
        ]);

        return redirect()->route('shipping_company.index')->with('success', 'Naviera actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingCompany $shippingCompany)
    {
        $shippingCompany->delete();
        return redirect()->route('shipping_company.index')->with('success', 'Naviera eliminado correctamente.');
    }

    public function validateForm($request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('shipping_companies', 'name')
                    ->ignore($id) // ignora el actual en caso de update
                    ->whereNull('deleted_at'),
            ],
            'contact' => 'nullable|string',
            'cellphone' => 'nullable|string',
            'email' => 'nullable|string'
        ]);
    }
}
