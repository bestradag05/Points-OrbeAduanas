<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;

class PointsController extends Controller
{

    public function getPointCustoms()
    {

        $personals = $this->getPersonalRoles('custom');

        $personalPoints = $personals->map(function ($personal) {


            $filteredRouting = $personal->routing->filter(function ($route) {

                return $route->custom != null;
            });

            // Contar el número de registros en la tabla custom
            $customCount = $filteredRouting->count();

            /* dump($customCount); */

            // Retornar el personal con el número de puntos
            return [
                'personal' => $personal,
                'puntos' => $customCount
            ];
        });


        return view('points/points-customs', compact('personalPoints'));
    }


    public function getPointFreight()
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


        return view('points/points-freight', compact('personalPoints'));

    }


    public function getPersonalRoles($relationship)
    {
        return Personal::whereHas('user.roles', function ($query) {
            $query->where('name', 'Asesor Comercial');
        })->with(['routing.'.$relationship => function ($query) {
            // Filtrar los registros de la tabla custom por estado 'Punto'
            $query->where('state', 'Generado');
        }])->get();

    }
}
