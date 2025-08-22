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
            'Total Puntos',
            'Profit',
            'Comision Generada',
            'Estado',
            'Acciones'
        ];

        return view('commissions/seller/list-seller-commission', compact('commissionsGroup', 'heads'));
    }


    public function getDetalCommissionsSeeller(String $id)
    {

        // Obtener el grupo y sus comisiones respectivas
        $commissionsGroup = CommissionGroups::with('sellerCommissions') // Cargar sellerCommissions con el grupo de comisiones
            ->where('id', $id) // Suponiendo que tienes el ID del commissionsGroup
            ->first();


        // Obtener el personal autenticado
        $freightCommissions = collect();
        $localCommissions = collect();

        foreach ($commissionsGroup->sellerCommissions as $commission) {
            if ($commission->commissionable_type === 'App\Models\Freight') {
                $freightCommissions->push($commission);
            } elseif ($commission->commissionable_type === 'App\Models\Transport' || $commission->commissionable_type === 'App\Models\Custom') {
                // Agrupar Aduana y Transporte bajo "localCommissions"
                $localCommissions->push($commission);
            }
        }

        // Validar si el vendedor puede generar profit por cada servicio
        $canGenerateProfit = [
            'freight' => false,
            'local' => false,
        ];

        // Validamos las condiciones para cada servicio
        /* if ($freightCommissions->isNotEmpty()) {
            $canGenerateProfit['freight'] = $this->profitValidationService->validateAllConditions($freightCommissions->first());
        } */
        if ($localCommissions->isNotEmpty()) {

            $localCommissions->each(function ($commission) use ($localCommissions) {
                // Añadir la propiedad 'total_remaining_balance' a cada comisión de forma temporal
                $commission->total_remaining_balance = $localCommissions->sum('remaining_balance');
            });

            // Validamos las condiciones para Aduana + Transporte (gastos locales)
            $canGenerateProfit['local'] = $this->profitValidationService->validateAllConditions($localCommissions);
        }


        // Pasar los datos a la vista
        return view('commissions/seller/detail-seller-commission', compact(
            'commissionsGroup',
            'canGenerateProfit',
            'freightCommissions',
            'localCommissions'
        ));
    }


    public function generatePointSeller(String $commissionType, String $commissionsGroup)
    {

        if ($commissionType === 'local') {
            $localCommissions = SellersCommission::whereIn('commissionable_type', ['App\Models\Custom', 'App\Models\Transport'])
                ->where('commission_group_id', $commissionsGroup)  // Aseguramos que sea el grupo correcto
                ->get();


            $totalRemainingBalance = $localCommissions->sum('remaining_balance');
            $points = floor($totalRemainingBalance / 45); // Cada 45 dólares es un punto
            $remainingBalance = $totalRemainingBalance - ($points * 45); // Calcular el nuevo saldo restante

            $pointsDistributed = 0;

            foreach ($localCommissions as $commission) {
                // Proporción de puntos basada en el saldo restante de cada comisión
                $proportionalPoints = floor(($commission->remaining_balance / $totalRemainingBalance) * $points);
                $proportionalRemainingBalance = ($commission->remaining_balance / $totalRemainingBalance) * $remainingBalance;

                //sumamos la cantidad de puntos distribuidos

                $pointsDistributed += $proportionalPoints;

                // Calcular los puntos adicionales para cada comisión (Aduana o Transporte)
                $oldAdditionalPoints = $commission->additional_points; // Obtener los puntos previos
                $currentAdditionalPoints = $oldAdditionalPoints + $proportionalPoints; // Sumar los puntos proporcionalmente

                // Calcular la comisión generada
                $generatedCommission = ($currentAdditionalPoints + $commission->pure_points) * 10;

                // Actualizar la comisión
                $commission->update([
                    'additional_points' => $currentAdditionalPoints,
                    'remaining_balance' => $proportionalRemainingBalance, // Actualizar el saldo restante
                    'generated_commission' => $generatedCommission // Calcular la comisión generada
                ]);
            }


            $remainingPoints = $points - $pointsDistributed;
            if ($remainingPoints > 0) {
                $lastCommission = $localCommissions->last();
                $lastCommission->increment('additional_points', $remainingPoints);

                // Calcular la comisión generada para los puntos adicionales
                $newAdditionalPoints = $lastCommission->additional_points; // Ahora tiene los puntos adicionales
                $generatedCommission = ($newAdditionalPoints + $lastCommission->pure_points) * 10; // La comisión generada

                // Actualizar la comisión generada con los puntos adicionales
                $lastCommission->update([
                    'generated_commission' => $generatedCommission
                ]);
            }

            $this->recalcCommisionGroup($commissionsGroup);

            return redirect()->back()->with('success', "Se generaron $points puntos adicionales para los gastos locales.");
        }


        if ($commissionType == 'freight') {
            // Obtener la comisión de Flete
            $freightCommission = SellersCommission::where('commissionable_type', 'App\Models\Freight')
                ->where('commission_group_id', $commissionsGroup) // Aseguramos que sea el grupo correcto
                ->first();

            // Calcular los puntos adicionales para Flete
            $oldAdditionalPoints = $freightCommission->additional_points; // Obtener los puntos previos
            $points = floor($freightCommission->remaining_balance / 45); // Cada 45 dólares es un punto
            $currentTotalAdditionlPoints = $oldAdditionalPoints + $points;
            $remainingBalance = $freightCommission->remaining_balance - ($points * 45); // Actualizar el saldo restante
            $generatedCommission = ($freightCommission->pure_points + $currentTotalAdditionlPoints) * 10; // Calcular la comisión generada

            // Actualizar la comisión de Flete
            $freightCommission->update([
                'additional_points' => $oldAdditionalPoints + $points,  // Sumar los puntos a Flete
                'remaining_balance' => $remainingBalance,  // Actualizar el saldo restante
                'generated_commission' => $generatedCommission  // Calcular la comisión generada
            ]);


            $this->recalcCommisionGroup($commissionsGroup);

            return redirect()->back()->with('success', "Se generaron $points puntos adicionales para el Flete.");
        }



        // Si no es 'freight' ni 'local', podemos devolver un error o manejar el caso según sea necesario
        return redirect()->back()->with('error', 'Tipo de comisión no válido.');
    }


    public function recalcCommisionGroup($commissionsGroup)
    {
        $group = CommissionGroups::findOrFail($commissionsGroup);

        // Inicializamos los totales
        $totalPurePoints = 0;
        $totalAdditionalPoints = 0;
        $totalProfit = 0;
        $totalCommission = 0;

        // Recuperamos todas las comisiones del grupo
        $commissions = SellersCommission::where('commission_group_id', $commissionsGroup)->get();

        // Iteramos sobre las comisiones y sumamos los puntos, profits y comisiones generadas
        foreach ($commissions as $commission) {
            // Acumulamos los puntos puros y los adicionales
            $totalPurePoints += $commission->pure_points;
            $totalAdditionalPoints += $commission->additional_points;

            // Acumulamos los profits y las comisiones generadas
            $totalProfit += $commission->distributed_profit; // Ganancia bruta
            $totalCommission += $commission->generated_commission; // Comisión generada
        }

        // Actualizamos los totales en el grupo de comisiones
        $group->update([
            'total_points_pure' => $totalPurePoints,
            'total_points_additional' => $totalAdditionalPoints,
            'total_points' => $totalPurePoints + $totalAdditionalPoints, // Total de puntos (puros + adicionales)
            'total_profit' => $totalProfit,
            'total_commission' => $totalCommission,
        ]);
    }

    public function generateProfit(String $commissionType, String $commissionsGroup)
    {
        if ($commissionType === 'local') {
            $localCommissions = SellersCommission::whereIn('commissionable_type', ['App\Models\Custom', 'App\Models\Transport'])
                ->where('commission_group_id', $commissionsGroup)  // Aseguramos que sea el grupo correcto
                ->get();


            $totalRemainingBalance = $localCommissions->sum('remaining_balance');

            $sellerProfit = $totalRemainingBalance / 2;
            $companyProfit = $totalRemainingBalance / 2;

            $localCommissions->each(function ($commission) use ($sellerProfit, $totalRemainingBalance) {
                // Calcular la proporción del profit para cada comisión
                $commissionProfit = ($commission->remaining_balance / $totalRemainingBalance) * $sellerProfit;

                // Asignar el profit distribuido a la comisión
                $commission->update([
                    'distributed_profit' => $commissionProfit,  // Asignar el profit proporcional
                    'remaining_balance' => 0,
                ]);
            });

            $this->recalcCommisionGroup($commissionsGroup);
            return redirect()->back()->with('success', "Profit generado correctamente para este servicio.");
        }


        if ($commissionType == 'freight') {

            $freightCommission = SellersCommission::where('commissionable_type', 'App\Models\Freight')
                ->where('commission_group_id', $commissionsGroup) // Aseguramos que sea el grupo correcto
                ->first();

            $sellerProfit = $freightCommission->remaining_balance / 2;
            $companyProfit = $freightCommission->remaining_balance / 2;

            
            $freightCommission->update([
                'distributed_profit' => $sellerProfit,  // Asignar los puntos calculados
                'remaining_balance' => 0,
            ]);

            $this->recalcCommisionGroup($commissionsGroup);

            return redirect()->back()->with('success', 'Profit generado correctamente para este servicio.');
        }
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
