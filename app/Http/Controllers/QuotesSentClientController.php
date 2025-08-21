<?php

namespace App\Http\Controllers;

use App\Models\CommissionGroups;
use App\Models\Points;
use App\Models\QuotesSentClient;
use App\Models\SellersCommission;
use App\Services\ProfitValidationService;
use App\Services\QuotesSentClientService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotesSentClientController extends Controller
{

    protected $quotesSentClientService;
    protected $profitValidationService;


    public function __construct(QuotesSentClientService $quotesSentClientService, ProfitValidationService $profitValidationService)
    {
        $this->quotesSentClientService = $quotesSentClientService;
        $this->profitValidationService = $profitValidationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compact = $this->quotesSentClientService->getQuotesSetClient();

        $heads = [
            '#',
            'N° de cotizacion',
            'ReF ##',
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



        return view('quotes_sent_client/list-quote-sent-client', array_merge($compact, compact('heads')));
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



    public function generatePDF($id)
    {
        $quoteSentClient = QuotesSentClient::findOrFail($id);

        $personal = $quoteSentClient->personal;


        $freightConcepts = $quoteSentClient->concepts()->wherePivot('service_type', 'Flete')->get();
        $customConcepts = $quoteSentClient->concepts()->wherePivot('service_type', 'Aduanas')->get();
        $transportConcepts = $quoteSentClient->concepts()->wherePivot('service_type', 'Transporte')->get();




        $pdf = Pdf::loadView('commercial_quote.pdf.commercial_quote_pdf', compact('quoteSentClient', 'freightConcepts', 'customConcepts', 'transportConcepts', 'personal'));

        return $pdf->stream('Cotizacion Comercial.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function updateStateQuoteSentClient(String $id, String $action, Request $request)
    {

        $quotesSentClient = QuotesSentClient::findOrFail($id);
        $status = '';

        if (!$quotesSentClient) {
            return redirect()->back()->with('error', 'No se encontro la cotización enviada al cliente.');
        }

        $justification = $request->input('justification');

        switch ($action) {
            case 'accept':
                # code...
                $status = 'Aceptado';

                /* Si es aceptado se debe generar un registro para la gestion de comisiones, ademas se debe generar al punto automatico para los servicios puros */

                //2. Generamos el registro para gestionar comisiones
                $this->createSellerCommission($quotesSentClient);

                break;
            case 'decline':
                # code...
                $status = 'Rechazado';
                break;
            case 'expired':
                # code...
                $status = 'Caducado';
                break;
            case 'cancel':
                # code...
                $status = 'Anulado';
                break;

            default:
                # code...
                $status = 'Pendiente';
                break;
        }


        $quotesSentClient->update(['status' => $status]);


        if ($justification) {
            $quotesSentClient->registerJustification($quotesSentClient, $status, $justification);
        }

        return redirect()->back()->with('success', 'Se actualizo el estado de la cotizacion enviada al cliente.');
    }


    private function createSellerCommission(QuotesSentClient $quotesSentClient)
    {
        // Obtener el comercial relacionado (commercialQuote)
        $commercialQuote = $quotesSentClient->commercialQuote;

        if ($commercialQuote) {

            //Creamos el registro para agrupar las comisiones de el vendedor

            $groupCommission = CommissionGroups::create([
                'commercial_quote_id' => $commercialQuote->id,
                'total_commission' => 0,
                'total_profit' => 0,
                'total_points' => 0
            ]);

            // Array de servicios
            $services = [];

            // Verificar si tiene servicios relacionados y agregarlos al array
            if ($commercialQuote->freight) {
                $services[] = $commercialQuote->freight;  // Agregar el servicio de flete
            }
            if ($commercialQuote->custom) {
                $services[] = $commercialQuote->custom;  // Agregar el servicio de aduana
            }
            if ($commercialQuote->transport) {
                $services[] = $commercialQuote->transport;  // Agregar el servicio de transporte
            }


            $totalPurePoints = 0;
            $totalAdditionalPoints = 0;
            $totalGrossProfit = 0;
            $totalGeneratedCommission = 0;

            foreach ($services as $service) {

                $netCost = null;
                $insurance = false;
                $purePoints = 1;

                if ($service instanceof \App\Models\Custom) {
                    $netCost = $service->net_amount;
                } else {
                    $netCost = $service->total_answer_utility;
                }

                //Verificamos si el servicio tiene un seguro relacionado
                if ($service->insurance && $service->insurance->exists()) {
                    $netCost = $netCost + $service->insurance->insurance_value;
                    $insurance = true;
                    $purePoints = $purePoints + 1;
                }

                // Crear el registro de comisión
                $sellerCommission = SellersCommission::create([
                    'commissionable_id' => $service->id,
                    'commissionable_type' => get_class($service),  // Tipo de servicio (QuotesSentClient)
                    'commission_group_id' => $groupCommission->id,
                    'personal_id' => $commercialQuote->id_personal,  // Relacionado al vendedor
                    'cost_of_sale' => $service->value_sale,  // Costo de venta total
                    'net_cost' =>  $netCost,  // Costo neto
                    'utility' => $service->value_utility,  // Utilidad
                    'insurance' => $insurance,  // Utilidad
                    'gross_profit' => $service->profit,  // Ganancia bruta total
                    'pure_points' => $purePoints,  // Puntos puros generados
                    'additional_points' => 0,  // Puntos adicionales generados
                    'distributed_profit' => 0,  // Ganancia distribuida
                    'remaining_balance' =>  $service->profit,  // Saldo restante para el vendedor
                    'generated_commission' => 10,  // Comisión generada
                ]);

                $pointsNeeded = $this->profitValidationService->checkMinPoints($sellerCommission);

                if ($pointsNeeded > 0) {
                    $points = min(floor($sellerCommission->remaining_balance / 45), $pointsNeeded);
                    $remainingBalance = $sellerCommission->remaining_balance - ($points * 45);
                    $generatedCommission = ($points + $sellerCommission->pure_points) * 10;

                    // Actualizar la comisión con los puntos faltantes y generados
                    $sellerCommission->update([
                        'additional_points' => $points,  // Asignar los puntos calculados
                        'remaining_balance' => $remainingBalance,
                        'generated_commission' => $generatedCommission
                    ]);
                }

                $totalPurePoints += $sellerCommission->pure_points;
                $totalAdditionalPoints += $sellerCommission->additional_points;
                $totalGrossProfit += $sellerCommission->distributed_profit;
                $totalGeneratedCommission += $sellerCommission->generated_commission;
            }

            $groupCommission->update([
                'total_points_pure' => $totalPurePoints,
                'total_points_additional' => $totalAdditionalPoints,
                'total_points' => $totalPurePoints + $totalAdditionalPoints,
                'total_profit' => $totalGrossProfit,  
                'total_commission' => $totalGeneratedCommission
            ]);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuotesSentClient $quotesSentClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuotesSentClient $quotesSentClient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuotesSentClient $quotesSentClient)
    {
        //
    }
}
