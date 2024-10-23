<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PointsController extends Controller
{

    public function getPointCustoms(Request $request)
    {


        $personals = $this->getPersonalRoles('custom');

        $personalPoints = $personals->map(function ($personal) {


            $filteredRouting = $personal->routing->filter(function ($route) {

                return $route->custom != null;
            });

            // Contar el número de registros en la tabla custom
            $customCount = $filteredRouting->count();

            // Retornar el personal con el número de puntos
            return [
                'personal' => $personal,
                'puntos' => $customCount
            ];
        });


        // Ordenamos del mayor al menor
        $personalPoints = $personalPoints->sortByDesc('puntos')->values();

        if ($request->type) {
            return response()->json($personalPoints);
        }

        return view('points/points-customs', compact('personalPoints'));
    }


    public function getPointFreight(Request $request)
    {        /* echo "<script>console.log(" . json_encode($endDate) . ");</script>"; */

        //Obtenemos todo el personal que tenga el rol de Asesor comercial y tenga relacion con la tabla freight
        $personals = $this->getPersonalRoles('freight');

        //Si las fechas existen, entonces lo convertimos en el formato adecuado

        // Convertir las fechas si están presentes en el formato adecuado
        $startDate = $request->startDate ? Carbon::parse($request->startDate)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();;
        $endDate = $request->endDate ? Carbon::parse($request->endDate)->endOfDay() : Carbon::now()->endOfMonth()->endOfDay();;
       
        //Vamos a recorrer los personales 
        $personalPoints = $personals->map(function ($personal) use ($startDate, $endDate)  {

            // ahora que tenemos los personales, obtenemos los routing que tienen estos personales y comenzamos a filtrar
            // Solo los routing que tenga una relacion con la tabla freight
            $filteredRouting = $personal->routing->filter(function ($route) use ($startDate, $endDate)  {

                $freightCondition = $route->freight != null;

                $dateCondition = true;
                if($startDate && $endDate){
                    $dateCondition = $route->freight->created_at >= $startDate && $route->freight->created_at <= $endDate;
                }

                return $freightCondition && $dateCondition;

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

        return view('points/points-freight');
    }



    public function getPointTransport(Request $request)
    {

        $personals = $this->getPersonalRoles('transport');

        $personalPoints = $personals->map(function ($personal) {


            $filteredRouting = $personal->routing->filter(function ($route) {

                return $route->freight != null;
            });

            // Contar el número de registros en la tabla custom
            $count = $filteredRouting->count();

            /* dump($customCount); */

            // Retornar el personal con el número de puntos
            return [
                'personal' => $personal,
                'puntos' => $count
            ];
        });


        // Ordenamos del mayor al menor
        $personalPoints = $personalPoints->sortByDesc('puntos')->values();

        if ($request->type) {
            return response()->json($personalPoints);
        }


        return view('points/points-transport', compact('personalPoints'));
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
