<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(!auth('api')->user()->can('list_rol')){
            return response()->json(["message"=>"EL USUARIO NO ESTA AUTORIZADO"],403);
        }

        $name=$request->search;

        $cargos=Cargo::where("name","like","%".$name."%")->orderBy("id","desc")->get();
        
        return response()->json([
            "cargos"=> $cargos->map(function($cargo){

                return[
                    "id"=> $cargo->id,
                    "name"=>$cargo->name,
                    "state"=>$cargo->state,
                ];
            }),

        ]);
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
        if(!auth('api')->user()->can('register_rol')){
            return response()->json(['message'=> "EL USUARIO NO ESTA AUTORIZADO"],403);
        }
        $exist_cargo=Cargo::where("name",$request->name)->first();
        if($exist_cargo){
            return response()->json([
                "message"=>403,
                "message_text"=>"EL NOMBRE DEL CARGO YA EXISTE"
            ]);
        }

        Cargo::create([
            'name' => $request->name,
            'state' => 'Activo'

        ]);

        return response()->json([
            "message" => "El cargo se registro",
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!auth('api')->user()->can('edit_rol')){
            return response()->json(["message"=>"EL USUARIO NO ESTA AUTORIZADO"],403);
        }
        
        $cargo= Cargo::findOrFail($id);
        return response()->json([

            "id"=> $cargo->id,
                    "name"=>$cargo->name,
                    "state"=>$cargo->state,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       /*  if(!auth('api')->user()->can('edit_cargo')){
            return response()->json(["message" => "EL USUARIO NO ESTA AUTORIZADO"],403);
        } */

        $is_cargo = Cargo::where("id","<>",$id)->where("name",$request->name)->first();

        if($is_cargo)
        {
            return response()->json([
                "messager" =>403,
                "message_text"=> "EL NOMBRE DEL CARGO YA EXISTE"
            ]);
        }
        $cargo=Cargo::findOrFail($id);
        
        $cargo->update($request->all());

        return response()->json([
            "message" => "El cargo se actualizo",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth('api')->user()->can('delete_rol')){
            return response()->json(["message"=>"EL USUARIO NO ESTA AUTORIZADO"],403);
        }

        $cargo=Cargo::findOrFail($id);

        $cargo->update(['state' => 'Inactivo']);

        return response()->json([
            "message"=> 200,
            "state" => $cargo->state
        ]);
    }
}
