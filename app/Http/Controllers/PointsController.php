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


        $personalPoints = [];

        foreach($personals as $personal){

            if ($personal->routing) {

                $personalPoints[$personal->id] = $personal->load('routing.custom', 'user.roles');
            
            }

        }
                

        return view('points/points-customs', compact('personalPoints'));


    }

}
