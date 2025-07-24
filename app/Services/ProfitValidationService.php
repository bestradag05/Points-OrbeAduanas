<?php

namespace App\Services;

use App\Models\Freight;
use App\Models\SellersCommission;

class ProfitValidationService
{
    /**
     * Verificar si la utilidad mínima es de $250
     */
    public function checkMinUtility($service)
    {
        return $service->utility >= 250;  // Aquí adaptamos para cada tipo de servicio
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
                ->sum('pure_points') + SellersCommission::where('personal_id', $personal->id)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
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
    public function checkMinRemainingProfit($service)
    {
        return $service->gross_profit >= 200;  // Aquí adaptamos para cada tipo de servicio
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
         $pointsNeeded = $this->checkMinPoints($service);
         $minPoints = true;

         if($pointsNeeded > 0)
         {
            $minPoints = false;
         }

        $conditions = [
            $this->checkMinUtility($service),
            $minPoints,
            $this->checkMinRemainingProfit($service)
        ];

        // Si alguna condición no se cumple, retorna false
        return !in_array(false, $conditions);
    }
}
