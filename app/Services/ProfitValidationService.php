<?php

namespace App\Services;

use App\Models\Freight;

class ProfitValidationService
{
    /**
     * Verificar si la utilidad mínima es de $250
     */
    public function checkMinUtility($service)
    {
        return $service->value_utility >= 200;  // Aquí adaptamos para cada tipo de servicio
    }

    /**
     * Verificar si se generaron al menos 10 puntos en el mes para el servicio relacionado
     */
    public function checkMinPoints($service)
    {
        // Obtenemos el personal asociado a la cotización comercial
        $commercialQuote = $service->commercial_quote;

        // Verificamos si la cotización tiene un personal relacionado
        if ($commercialQuote && $commercialQuote->personal) {
            $personal = $commercialQuote->personal;
            $currentMonth = now()->month;
            $currentYear = now()->year;

            // Sumar los puntos de todas las cotizaciones comerciales asociadas al personal
            $totalPointsThisMonth = $this->getTotalPointsForPersonal($personal, $currentYear, $currentMonth);

            return $totalPointsThisMonth >= 10;
        }

        return false;
    }

    /**
     * Verificar si la ganancia mínima restante es de $200
     */
    public function checkMinRemainingProfit($service)
    {
        return $service->profit >= 200;  // Aquí adaptamos para cada tipo de servicio
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
        $conditions = [
            $this->checkMinUtility($service),
            $this->checkMinPoints($service),
            $this->checkMinRemainingProfit($service)
        ];

        // Si alguna condición no se cumple, retorna false
        return !in_array(false, $conditions);
    }
}
