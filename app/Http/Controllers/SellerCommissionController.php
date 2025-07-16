<?php

namespace App\Http\Controllers;

use App\Models\CommercialQuote;
use App\Models\Freight;
use App\Services\CommercialQuoteService;
use App\Services\ProfitValidationService;
use Illuminate\Http\Request;

class SellerCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    protected $commercialQuoteService;
    protected $profitValidationService;

    public function __construct(CommercialQuoteService $commercialQuoteService, ProfitValidationService $profitValidationService)
    {
        $this->commercialQuoteService = $commercialQuoteService;
        $this->profitValidationService = $profitValidationService;
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

        $enabledProfit = [
            'freight' => false,
            'transport' => false,
            'custom' => false
        ];

        //Verificamos si el personal autenticado tiene puntos:
        $personal = auth()->user()->personal;
        $currentMonth = now()->month;
        $currentYear = now()->year;


        // Creamos una instancia del servicio de validación de profit
        $profitService = new ProfitValidationService();

        // Validamos las condiciones para cada servicio
        if ($commercialQuote->freight) {
            $enabledProfit['freight'] = $profitService->validateAllConditions($commercialQuote->freight);
        }

        if ($commercialQuote->transport) {
            $enabledProfit['transport'] = $profitService->validateAllConditions($commercialQuote->transport);
        }

        if ($commercialQuote->custom) {
            $enabledProfit['custom'] = $profitService->validateAllConditions($commercialQuote->custom);
        }


        return view('commissions/seller/detail-seller-commission', compact('commercialQuote', 'enabledProfit'));
    }


    public function generatePointSeller(Request $request)
    {
        $typeService = $request->typeService; // Este valor debe ser 'freight' u otros tipos si es necesario
        $serviceId = $request->idService;
        $points = $request->points;

        $pricePerPoint = 45;


        switch ($typeService) {
            case 'freight':
                $freight = Freight::findOrFail($serviceId);
                $revenue = $freight->profit;
                $totalPointsCost = $points * $pricePerPoint;

                if ($totalPointsCost > $revenue) {
                    // Redirigir con un mensaje de error
                    return redirect()->back()->with('error', 'No hay suficiente ganancia para generar los puntos solicitados.');
                }

                // Calcular la ganancia restante después de generar los puntos
                $remaining_profit = $revenue - $totalPointsCost;

                $freight->profit = $remaining_profit;
                $freight->save();


                $freight->points()->create([
                    'personal_id' => auth()->user()->personal->id,
                    'point_type' => 'adicional',  // Suponiendo que estos son puntos adicionales
                    'quantity' => $points         // La cantidad de puntos generados
                ]);


                /* Calculamos las comisiones x la cantidad de puntos obtenidos */
                $totalPoints = $freight->points->sum('quantity');
                $commisionAmount = $totalPoints * 10;

                $freight->sellerCommissions()->create([
                    'personal_id' => auth()->user()->personal->id,  // Suponiendo que el vendedor está autenticado
                    'points' => $totalPoints,
                    'amount' => $commisionAmount,
                ]);


                // Redirigir con un mensaje de éxito
                return redirect()->back()->with('success', 'Puntos generados correctamente. Ganancia restante: $' . number_format($remaining_profit, 2));


                break;

            default:
                # code...
                break;
        }
    }


    public function generateProfit(Request $request)
    {
        dd($request->all());
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
