<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->search;

        $services = Service::where("name","like","%".$name."%")->orderBy("id","desc")->get();

        return response()->json([
            "services" => $services->map(function($service) {
                return [
                    "id" => $service->id,
                    "name" => $service->name,
                    "state" => $service->state
                ];
            }),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $exist_service = Service::where("name", $request->name)->first();

        if($exist_service){
            return response()->json([
                "message" => 403,
                "message_text" => "EL SERVICIO DEL DOCUMENTO YA EXISTE"
            ]);
        }

        Service::create([
            'name' => $request->name,
            'state' => 'Activo'
        ]);

        return response()->json([
            "message" => 200,
        ]);
    }

    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return response()->json([
            "id" => $service->id,
            "name" => $service->name,
            "state" => $service->state,
            "created_at" => $service->created_at->format("Y-m-d h:i:s")
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $is_service = Service::where("id","<>",$id)->where("name",$request->name)->first();

        if($is_service){
            return response()->json([
                "message" => 403,
                "message_text" => "EL SERVICIO DEL ROL YA EXISTE"
            ]);
        }

        $service = Service::findOrFail($id);

        $service->update($request->all());
        return response()->json([
            "message" => 200,
        ]);
    }

    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return response()->json([
            "message" => 200,
        ]);
    }
}
