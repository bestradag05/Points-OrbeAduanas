<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Money\MoneyCollection;
use App\Http\Resources\Money\MoneyResource;
use Illuminate\Http\Request;
use App\Models\Money;


class MoneyController extends Controller
{
    public function index(Request $request)
    {
        $money = $request->search;

        $moneys = Money::where("money","like","%".$money."%")->orderBy("id","desc")->get();

        return response()->json([
            "moneys" => $moneys->map(function($money) {
                return [
                    "id" => $money->id,
                    "money" => $money->money,
                    "description" => $money->description
                ];
            }),
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $exist_money = Money::where("money", $request->money)->first();

        if($exist_money){
            return response()->json([
                "message" => 403,
                "message_text" => "LA MONEDA YA EXISTE"
            ]);
        }

        Money::create([
            'money' => $request->money,
            'description' => $request->description ,
            'state' => 'Activo'
        ]);

        return response()->json([
            "message" => 200,
        ]);
    }

    public function show(string $id)
    {
        $money = Money::findOrFail($id);
        return response()->json([
            "id" => $money->id,
            "money" => $money->money,
            "description" => $money->description,
            "state" => $money->state,
            "created_at" => $money->created_at->format("Y-m-d h:i:s")
        ]);
    }

    public function edit(string $id)
    {

    }

    public function update(Request $request, string $id)
    {
        $is_money = Money::where("id","<>",$id)->where("money",$request->money)->first();

        if($is_money){
            return response()->json([
                "message" => 403,
                "message_text" => "LA MONEDA YA EXISTE"
            ]);
        }

        $money = Money::findOrFail($id);

        $money->update($request->all());
        return response()->json([
            "message" => 200,
        ]);
    }

    public function destroy(string $id)
    {
        $money = Money::findOrFail($id);

        $money->delete();
        return response()->json([
            "message" => 200,
        ]);
    }
}
