<?php

namespace App\Http\Controllers;

use App\Models\CommercialQuote;
use App\Models\CommissionGroups;
use App\Models\Custom;
use App\Models\Freight;
use App\Models\Profit;
use App\Models\SellersCommission;
use App\Models\Transport;
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

        // Obtener el personal autenticado
        $personal = auth()->user()->personal;

        // Filtrar los commercialQuotes que tienen al menos un servicio con una comisión registrada
        /*   $commercialQuotes = CommercialQuote::whereHas('freight.sellerCommissions', function ($query) use ($personal) {
            $query->where('personal_id', $personal->id);  // Verificamos si el vendedor tiene comisiones en flete
        })
            ->orWhereHas('transport.sellerCommissions', function ($query) use ($personal) {
                $query->where('personal_id', $personal->id);  // Verificamos si el vendedor tiene comisiones en transporte
            })
            ->orWhereHas('custom.sellerCommissions', function ($query) use ($personal) {
                $query->where('personal_id', $personal->id);  // Verificamos si el vendedor tiene comisiones en aduana
            })
            ->get(); */

        $commissionsGroup = CommissionGroups::whereHas('commercialQuote', function ($query) use ($personal) {
            $query->where('id_personal', $personal->id);
        })->get();

        $heads = [
            '#',
            'N° de cotizacion',
            'Origen',
            'Destino',
            'Cliente',
            'Fecha',
            'Puntos',
            'Profit',
            'Comision Generada',
            'Estado',
            'Acciones'
        ];

        return view('commissions/seller/list-seller-commission', compact('commissionsGroup', 'heads'));
    }


    public function getDetalCommissionsSeeller(String $id)
    {

        // Obtener la cotización comercial (commercialQuote) por su ID
        $commissionsGroup = CommissionGroups::with('sellerCommissions') // Cargar sellerCommissions con el grupo de comisiones
            ->where('id', $id) // Suponiendo que tienes el ID del commissionsGroup
            ->first();

        dd($commissionsGroup);

        // Obtener el personal autenticado
        $personal = auth()->user()->personal;

        // Comisiones de Flete
        $freightCommissions = collect();
        if ($commercialQuote->freight) {
            $freightCommissions = SellersCommission::where('commissionable_id', $commercialQuote->freight->id)
                ->where('commissionable_type', 'App\Models\Freight')  // Aseguramos que sean comisiones de "flete"
                ->where('personal_id', $personal->id)
                ->get();
        }

        // Comisiones de Transporte
        $transportCommissions = collect();
        if ($commercialQuote->transport) {
            $transportCommissions = SellersCommission::where('commissionable_id', $commercialQuote->transport->id)
                ->where('commissionable_type', 'App\Models\Transport')  // Aseguramos que sean comisiones de "transporte"
                ->where('personal_id', $personal->id)
                ->get();
        }

        // Comisiones de Aduana
        $customCommissions = collect();
        if ($commercialQuote->custom) {
            $customCommissions = SellersCommission::where('commissionable_id', $commercialQuote->custom->id)
                ->where('commissionable_type', 'App\Models\Custom')  // Aseguramos que sean comisiones de "aduana"
                ->where('personal_id', $personal->id)
                ->get();
        }


        // Validar si el vendedor puede generar profit por cada servicio
        $canGenerateProfit = [
            'freight' => false,
            'transport' => false,
            'custom' => false
        ];

        // Validamos las condiciones para cada servicio
        if ($commercialQuote->freight && $freightCommissions->isNotEmpty()) {
            $canGenerateProfit['freight'] = $this->profitValidationService->validateAllConditions($freightCommissions->first());
        }

        if ($commercialQuote->transport && $transportCommissions->isNotEmpty()) {
            $canGenerateProfit['transport'] = $this->profitValidationService->validateAllConditions($transportCommissions->first());
        }

        if ($commercialQuote->custom && $customCommissions->isNotEmpty()) {
            $canGenerateProfit['custom'] = $this->profitValidationService->validateAllConditions($customCommissions->first());
        }


        // Pasar los datos a la vista
        return view('commissions/seller/detail-seller-commission', compact(
            'commercialQuote',
            'canGenerateProfit',
            'freightCommissions',
            'transportCommissions',
            'customCommissions'
        ));
    }


    public function generatePointSeller(SellersCommission $sellerCommission)
    {

        $oldAdditionalPoints = $sellerCommission->additional_points;

        // Calcular los puntos adicionales
        $points = floor($sellerCommission->remaining_balance / 45);
        $remainingBalance = $sellerCommission->remaining_balance - ($points * 45);
        $currentAdditionalPoints = $oldAdditionalPoints + $points;
        $generatedCommission = ($currentAdditionalPoints + $sellerCommission->pure_points) * 10;



        $sellerCommission->update([
            'additional_points' => $currentAdditionalPoints,  // Asignar los puntos calculados
            'remaining_balance' => $remainingBalance,
            'generated_commission' => $generatedCommission
        ]);

        // Retornar un mensaje o redirigir a una vista
        return redirect()->back()->with('success', "Se generaron $points puntos adicionales.");
    }


    public function generateProfit(SellersCommission $sellerCommission)
    {

        $sellerProfit = $sellerCommission->gross_profit / 2;
        $companyProfit = $sellerCommission->gross_profit / 2;


        $sellerCommission->update([
            'distributed_profit' => $sellerProfit,  // Asignar los puntos calculados
        ]);

        return redirect()->back()->with('success', 'Profit generado correctamente para este servicio.');
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
