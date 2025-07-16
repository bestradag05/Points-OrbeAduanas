<?php

namespace App\Http\Controllers;

use App\Models\CommercialQuote;
use App\Models\Commission;
use App\Models\Freight;
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


    public function generatePointSeller(Request $request)
    {

        $typeService = $request->typeService; // Este valor debe ser 'freight' u otros tipos si es necesario
        $serviceId = $request->idService;
        $points = $request->points;

        $pricePerPoint = 45;


        switch ($typeService) {
            case 'freight':
                $freight = Freight::findOrFail($request->idService);
                $revenue = $freight->profit_on_freight; //Ganancia
                $totalPointsCost = $points * $pricePerPoint; //precio por puntos

                if ($totalPointsCost > $revenue) {
                    // Redirigir con un mensaje de error
                    return redirect()->back()->with('error', 'No hay suficiente ganancia para generar los puntos solicitados.');
                }

                // Calcular la ganancia restante después de generar los puntos
                $remaining_profit = $revenue - $totalPointsCost;

                $freight->profit_on_freight = $remaining_profit;
                $freight->save();


                $freight->points()->create([
                    'point_type' => 'adicional',  // Suponiendo que estos son puntos adicionales
                    'quantity' => $points         // La cantidad de puntos generados
                ]);


                // Redirigir con un mensaje de éxito
                return redirect()->back()->with('success', 'Puntos generados correctamente. Ganancia restante: $' . number_format($remaining_profit, 2));


                break;

            default:
                # code...
                break;
        }
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
