<?php

namespace App\Http\Controllers;

use App\Models\CommercialQuote;
use App\Models\Commission;
use App\Services\CommercialQuoteService;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    protected $commercialQuoteService;

    public function __construct(CommercialQuoteService $commercialQuoteService)
    {
        $this->commercialQuoteService = $commercialQuoteService;
    }


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


    public function getCommissionsSeeller()
    {

        $compact = $this->commercialQuoteService->getQuotes(['state' => 'Aceptado']);

        $heads = [
            '#',
            'N° de cotizacion',
            'Origen',
            'Destino',
            'Cliente',
            'Tipo de embarque',
            'Asesor Comercial',
            'Consolidado',
            'Fecha',
            'Estado',
            'Acciones'
        ];

        return view('commissions/seller/list-seller-commission', array_merge($compact, compact('heads')));
    }


    public function getDetalCommissionsSeeller($id)
    {

        $commercialQuote = CommercialQuote::findOrFail($id);

        return view('commissions/seller/detail-seller-commission', compact('commercialQuote'));
    }


    public function generatePointSeller(Request $request){
        dd($request->all());
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
