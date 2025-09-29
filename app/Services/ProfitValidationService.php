<?php

namespace App\Services;

use App\Models\Freight;
use App\Models\SellersCommission;
use Illuminate\Support\Facades\Log;

class ProfitValidationService
{
    /**
     * Verificar si la utilidad mínima es de $250
     */
    public function checkMinUtility($service)
    {

        $requiredUtility = 250; // Utilidad mínima

        // Verificar si la utilidad actual es suficiente
        if ($service->utility < $requiredUtility) {
            // Calcular cuánto falta para alcanzar la utilidad mínima
            $requiredBalance = $requiredUtility - $service->utility;

            // Verificar si el vendedor tiene suficiente saldo restante para cubrir la diferencia
            if ($service->remaining_balance >= $requiredBalance) {
                // Calcular la ganancia ajustada después de cubrir la diferencia
                $remainingBalanceAfterAdjustment = $service->remaining_balance - $requiredBalance;
                if ($this->checkMinRemainingProfit($remainingBalanceAfterAdjustment)) {

                    $adjustedSellerProfit = $remainingBalanceAfterAdjustment / 2; // Dividir entre 2

                    // Retornar tanto el monto descontado como el nuevo profit ajustado
                    return [
                        'checkCondition' => true,
                        'adjustedProfit' => $adjustedSellerProfit,
                        'remaining_balance' => $remainingBalanceAfterAdjustment,
                        'discountForUtility' => $requiredBalance,
                        'isAdjusted' => true,
                    ];
                }
            }
        } else {

            // Si no es necesario hacer ajustes, solo retornar la ganancia dividida entre 2
            return [
                'checkCondition' => true,
                'adjustedProfit' => $service->remaining_balance / 2,
                'remaining_balance' => $service->remaining_balance,
                'discountForUtility' => 0,
                'isAdjusted' => false,
            ];
        }

        // Si no es necesario hacer ajustes, solo retornar la ganancia dividida entre 2
        return [
            'checkCondition' => false,
            'adjustedProfit' => $service->remaining_balance / 2,
            'remaining_balance' => $service->remaining_balance,
            'discountForUtility' => 0,
            'isAdjusted' => false,
        ];
    }

    /**
     * Verificar si se generaron al menos 10 puntos en el mes para el servicio relacionado
     */
    public function checkMinPoints($service)
    {
        if (isset($service->commissionable)) {
            // Obtener el personal asociado a la cotización comercial
            $personal = $service->commissionable->commercial_quote->personal;

            // Si no hay personal relacionado, devolver false
            if (!$personal) {
                return 0;  // Si no hay personal, no se pueden generar puntos
            }

            // Obtener los puntos generados por este personal en el mes y año actuales
            $currentMonth = now()->month;
            $currentYear = now()->year;

            // Calcular la suma de puntos (pure_points + additional_points) en la tabla seller_commission
            $totalPointsThisMonth = SellersCommission::where('personal_id', $personal->id)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->whereHas('commissionsGroup', function ($query) {
                    $query->where('status', '!=', 'Anulado');  // Excluir los SellerCommissions de grupos anulados
                })
                ->sum('pure_points') + SellersCommission::where('personal_id', $personal->id)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->whereHas('commissionsGroup', function ($query) {
                    $query->where('status', '!=', 'Anulado');  // Excluir los SellerCommissions de grupos anulados
                })
                ->sum('additional_points');

            // Verificar los puntos faltantes para llegar a 10
            $pointsNeeded = 10 - $totalPointsThisMonth;

            return $pointsNeeded > 0 ? $pointsNeeded : 0;  // Si faltan puntos, devolver la cantidad, sino 0
        }

        // Si el servicio no tiene relación con commercialQuote, no podemos verificar los puntos
        return 0;
    }

    /**
     * Verificar si la ganancia mínima restante es de $200
     */
    public function checkMinRemainingProfit($remaining_balance)
    {
        return $remaining_balance >= 200;  // Aquí adaptamos para cada tipo de servicio
    }



    public function getTotalPointsForPersonal($personal, $currentYear, $currentMonth)
    {
        // Obtenemos todos los puntos generados por el personal en el mes y año actuales
        return $personal->commercialQuotes()
            ->whereYear('created_at', $currentYear) // Aseguramos que el año sea el actual
            ->whereMonth('created_at', $currentMonth) // Filtramos por el mes actual
            ->where(function ($query) use ($currentYear, $currentMonth) {
                // Aseguramos que haya al menos una relación válida con los servicios
                $query->whereHas('freight', function ($query) use ($currentYear, $currentMonth) {
                    $query->whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth);
                })
                    ->orWhereHas('transport', function ($query) use ($currentYear, $currentMonth) {
                        $query->whereYear('created_at', $currentYear)
                            ->whereMonth('created_at', $currentMonth);
                    })
                    ->orWhereHas('custom', function ($query) use ($currentYear, $currentMonth) {
                        $query->whereYear('created_at', $currentYear)
                            ->whereMonth('created_at', $currentMonth);
                    });
            })
            ->with(['freight', 'transport', 'custom'])  // Cargar las relaciones de los servicios
            ->get()
            ->flatMap(function ($quote) {
                // Usamos merge solo si la relación no está vacía
                $freights = collect([$quote->freight])->filter();  // Si no hay 'freight', será vacío
                $transports = collect([$quote->transport])->filter();  // Si no hay 'transport', será vacío
                $customs = collect([$quote->custom])->filter();  // Si no hay 'custom', será vacío

                // Fusionamos las colecciones de forma segura
                return $freights->merge($transports)->merge($customs);
            })
            ->flatMap(function ($service) {
                // Verificar que el servicio tenga puntos antes de intentar acceder a ellos
                return $service->points ?: collect();  // Si no tiene puntos, usamos una colección vacía
            })
            ->sum('quantity');  // Sumamos la cantidad de puntos de todos los servicios relacionados
    }


    /**
     * Validar todas las condiciones
     */
    public function validateAllConditions($service)
    {
        $conditions = [];
        $pointsNeeded = $this->checkMinPoints($service);
        $minPoints = true;

        if ($pointsNeeded > 0) {
            $minPoints = false;
        }

        if ($service->first()->commissionable_type === "App\Models\Freight") {

            $utilityCheck = $this->checkMinUtility($service);

            $conditions = [
                $utilityCheck['checkCondition'],
                $minPoints,
                $this->checkMinRemainingProfit($service->remaining_balance)
            ];
        } else {
            $totalRemainingBalance = $service->first()->total_remaining_balance;
            $conditions = [
                $minPoints,
                $this->checkMinRemainingProfit($totalRemainingBalance)
            ];
        }

        // Si alguna condición no se cumple, retorna false
        return !in_array(false, $conditions);
    }
}
