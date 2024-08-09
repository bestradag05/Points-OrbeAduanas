<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!auth('api')->user()->can('list_rol')){
            return response()->json(["message"=>"EL USUARIO NO ESTA AUTORIZADO"],403);
        }

        $nombre=$request->search;

        $cargos=Cargo::where("nombre","like","%".$nombre."%")->orderBy("id","desc")->get();
        
        return response()->json([
            "roles"=> $cargos->map(function($cargo){

                return[
                    "id"=> $cargo->id,
                    "nombre"=>$cargo->nombre,
                    "CodUsuarioR"=>$cargo->CodUsuarioR,
                    "Registro"=>$cargo->Registro->format("Y-m-d h:i:s"),
                    "CodUsuarioE"=>$cargo->$CodUsuarioE,
                    "RegistroE"=>$cargo->RegistroE->format("Y-m-d h:i:s"),
                    "estado"=>$cargo->estado
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
        $exist_cargo=Cargo::where("nombre",$request->nombre)->first();
        if($exist_cargo){
            return response()->json([
                "message"=>403,
                "message_text"=>"EL NOMBRE DEL CARGO YA EXISTE"
            ]);
        }

        $cargo = Cargo::create([
            'guard_nombre' => 'api',
            'nombre' => $request->nombre
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!auth('api')->user()->can('edit_rol')){
            return response()->json(["message"=>"EL USUARIO NO ESTA AUTORIZADO"],403);
        }
        $cargo=Cargo::finOrFail($id);
        return response()->json([

            "id"=> $cargo->id,
                    "nombre"=>$cargo->nombre,
                    "CodUsuarioR"=>$cargo->CodUsuarioR,
                    "Registro"=>$cargo->Registro->format("Y-m-d h:i:s"),
                    "CodUsuarioE"=>$cargo->$CodUsuarioE,
                    "RegistroE"=>$cargo->RegistroE->format("Y-m-d h:i:s"),
                    "estado"=>$cargo->estado

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!auth('api')->user()->can('edit_cargo')){
            return response()->json(["message" => "EL USUARIO NO ESTA AUTORIZADO"],403);
        }
        $is_cargo = Cargo::where("id","<>",$id)->where("nombre",$request->nombre)->first();

        if($is_cargo)
        {
            return response()->json([
                "messager" =>403,
                "message_text"=> "EL NOMBRE DEL CARGO YA EXISTE"
            ]);
        }
        $cargo=Cargo::findOrFail($id);
        
        $cargo->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!auth('api')->user()->can('delete_rol')){
            return response()->json(["message"=>"EL USUARIO NO ESTA AUTORIZADO"],403);
        }

        /* $cargo=Cargo::finOrFail($id);
        if($cargo->users->count()>0){
            return response()->json([
                "message"=> 403,
                "message_text" => "EL ROL SELECCIONADO NO SE PUEDE ELIMINAR"
            ]);
        } */

        $cargo->delete();
        return response()->json([
            "message"=> 200,
        ]);
    }
}
