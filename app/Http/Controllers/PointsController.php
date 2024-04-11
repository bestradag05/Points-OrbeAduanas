<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;

class PointsController extends Controller
{

    public function getPointCustoms(){

        //Obtenemos el personal que tenga roles de Asesores comerciales

        $personals = Personal::whereHas('user.roles', function($query){
            
            $query->where('name', 'Asesor Comercial');

        })->get();


        foreach($personals as $personal){

            if ($personal->routing) {
                /* var_dump( $personal->name. ': '  . $personal->routing->custom()->count() ); */
                $personal->load('routing.custom');
                dump($personal->routing->nro_operation);
               
            }

        }
                



    }

}
