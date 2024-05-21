<?php

namespace App\Http\Controllers;

use App\Models\Personal;
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

        if($request->type){
            return response()->json($personalPoints);
        }

        return view('points/points-customs', compact('personalPoints'));
    }


    public function getPointFreight(Request $request)
    {

        $personals = $this->getPersonalRoles('freight');

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

        if($request->type){
            return response()->json($personalPoints);
        }


        return view('points/points-freight', compact('personalPoints'));

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

        if($request->type){
            return response()->json($personalPoints);
        }


        return view('points/points-transport', compact('personalPoints'));

    }



    public function getPointDetail() {


        $personalPoints =$this->getPersonalRoles(null);
        dd($personalPoints);
        

        return view('points/points-detail', compact('personalPoints'));
    }




    public function getPersonalRoles($relationship)
    {
        
        if($relationship != null){

            return Personal::whereHas('user.roles', function ($query) {
                $query->where('name', 'Asesor Comercial');
            })->with(['routing.'.$relationship => function ($query) {
                // Filtrar los registros de la tabla custom por estado 'Punto'
                $query->where('state', 'Generado');
            }])->get();
        }else{
            return Personal::whereHas('user.roles', function ($query) {
                $query->where('name', 'Asesor Comercial');
            })->get();
        }

    }
}
