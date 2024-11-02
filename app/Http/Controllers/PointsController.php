<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use App\Models\Freight;
use App\Models\Insurance;
use App\Models\Personal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PointsController extends Controller
{

    public function getPointCustoms(Request $request)
    {
        return $this->getPointsService($request, 'custom');
    }

    public function getPointFreight(Request $request)
    {

        return $this->getPointsService($request, 'freight');
    }

    public function getPointTransport(Request $request)
    {

        return $this->getPointsService($request, 'transport');
    }



    public function getPointInsurance(Request $request)
    {
        $personals = Personal::whereHas('user.roles', function ($query) {
            $query->where('name', 'Asesor Comercial');
        })
            ->whereHas('routing.custom.insurance', function ($query) {
                $query->where('state', 'Generado')->where('model_insurable_service', Custom::class);
            })
            ->orWhereHas('routing.freight.insurance', function ($query) {
                $query->where('state', 'Generado')->where('model_insurable_service', Freight::class);
            })
            ->with([
                'routing.custom.insurance' => function ($query) {
                    $query->where('state', 'Generado')->where('model_insurable_service', Custom::class);
                },
                'routing.freight.insurance' => function ($query) {
                    $query->where('state', 'Generado')->where('model_insurable_service', Freight::class);
                }
            ])
            ->get();


        $startDate = $request->startDate ? Carbon::parse($request->startDate)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();;
        $endDate = $request->endDate ? Carbon::parse($request->endDate)->endOfDay() : Carbon::now()->endOfMonth()->endOfDay();;


        $personalPoints = $personals->map(function ($personal) use ($startDate, $endDate) {

            // Ahora que tenemos los personales, obtenemos los routing y comenzamos a filtrar
            $filteredRouting = $personal->routing->filter(function ($route) use ($startDate, $endDate) {
        
                $points = 0;
        
                // Verificar si el routing tiene un custom con insurance dentro de las fechas
                if ($route->custom && $route->custom->insurance) {
                    $insuranceDate = $route->custom->insurance->created_at;
                    if ($insuranceDate >= $startDate && $insuranceDate <= $endDate) {
                        $points++; // Suma 1 punto si el custom tiene un insurance válido
                    }
                }
        
                // Verificar si el routing tiene un freight con insurance dentro de las fechas
                if ($route->freight && $route->freight->insurance) {
                    $insuranceDate = $route->freight->insurance->created_at;
                    if ($insuranceDate >= $startDate && $insuranceDate <= $endDate) {
                        $points++; // Suma 1 punto si el freight tiene un insurance válido
                    }
                }
        
                // Solo incluimos el routing si tiene al menos 1 punto
                return $points > 0;
            });
        
            // Sumar los puntos para todos los routing filtrados
            $count = $filteredRouting->reduce(function ($carry, $route) use ($startDate, $endDate) {
                $points = 0;
        
                // Sumar puntos si el custom tiene un insurance en las fechas indicadas
                if ($route->custom && $route->custom->insurance) {
                    $insuranceDate = $route->custom->insurance->created_at;
                    if ($insuranceDate >= $startDate && $insuranceDate <= $endDate) {
                        $points++;
                    }
                }
        
                // Sumar puntos si el freight tiene un insurance en las fechas indicadas
                if ($route->freight && $route->freight->insurance) {
                    $insuranceDate = $route->freight->insurance->created_at;
                    if ($insuranceDate >= $startDate && $insuranceDate <= $endDate) {
                        $points++;
                    }
                }
        
                // Agregar los puntos de este routing al total
                return $carry + $points;
            }, 0);
        
            // Retornar el personal con el número total de puntos
            return [
                'personal' => $personal,
                'puntos' => $count
            ];
        });


         // Ordenamos del mayor al menor
         $personalPoints = $personalPoints->sortByDesc('puntos')->values();


         //verificamos que sea una solicitud ajax para reenviar como json la informacion
         if ($request->type) {
             return response()->json($personalPoints);
         }
 
         return view('points/points-insurance');
    }



    public function getPointsService($request, $service)
    {
        //Obtenemos todo el personal que tenga el rol de Asesor comercial y tenga relacion con la tabla freight
        $personals = $this->getPersonalRoles($service);

        /*  echo "<script>console.log(" . json_encode($personals) . ");</script>"; */

        //Si las fechas existen, entonces lo convertimos en el formato adecuado

        // Convertir las fechas si están presentes en el formato adecuado
        $startDate = $request->startDate ? Carbon::parse($request->startDate)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();;
        $endDate = $request->endDate ? Carbon::parse($request->endDate)->endOfDay() : Carbon::now()->endOfMonth()->endOfDay();;

        //Vamos a recorrer los personales 
        $personalPoints = $personals->map(function ($personal) use ($startDate, $endDate, $service) {

            // ahora que tenemos los personales, obtenemos los routing que tienen estos personales y comenzamos a filtrar
            // Solo los routing que tenga una relacion con la tabla freight
            $filteredRouting = $personal->routing->filter(function ($route) use ($startDate, $endDate, $service) {


                // Verificar si $route->custom no es nulo antes de acceder a created_at
                if ($route->{$service}) {
                    $dateCondition = $route->{$service}->created_at >= $startDate && $route->{$service}->created_at <= $endDate;
                    return $dateCondition;
                }

                return false;
            });

            // Contar el número de registros en la tabla freigth
            $count = $filteredRouting->count();


            // Retornar el personal con el número de puntos
            return [
                'personal' => $personal,
                'puntos' => $count
            ];
        });



        // Ordenamos del mayor al menor
        $personalPoints = $personalPoints->sortByDesc('puntos')->values();


        //verificamos que sea una solicitud ajax para reenviar como json la informacion
        if ($request->type) {
            return response()->json($personalPoints);
        }

        return view('points/points-' . $service);
    }



    public function getPointDetail()
    {


        $personalPoints = $this->getPersonalRoles(null);


        return view('points/points-detail', compact('personalPoints'));
    }




    public function getPersonalRoles($relationship)
    {

        if ($relationship != null) {

            return Personal::whereHas('user.roles', function ($query) {
                $query->where('name', 'Asesor Comercial');
            })->with(['routing.' . $relationship => function ($query) {
                // Filtrar los registros de la tabla custom por estado 'Punto'
                $query->where('state', 'Generado');
            }])->get();
        } else {
            return Personal::whereHas('user.roles', function ($query) {
                $query->where('name', 'Asesor Comercial');
            })->get();
        }
    }
}
