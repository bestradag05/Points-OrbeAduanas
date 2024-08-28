<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::all();

        return response()->json([
            "contracts" => $contracts->map(function($contract) {
                return [
                    "personal" => $contract->personal,
                    "img_url" => $contract->personal->img_url ? env("APP_URL") . "storage/" . $contract->personal->img_url : env("APP_URL") . "storage/personals/user_default.png",
                    "start_date" => $contract->start_date,
                    "end_date" => $contract->end_date,
                    "salary" => $contract->salary,
                    "state" => $contract->state
                ];
            }),
        ], 200);
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
        $formattedDateStart =  $this->formatdateUTC($request->start_date);
        $formattedDateEnd =  $this->formatdateUTC($request->end_date);

        $request->merge([
            'start_date' => $formattedDateStart,
            'end_date' => $formattedDateEnd
        ]);

        Contract::create([
            'id_personal' => $request->id_personal,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'salary' => $request->salary,
            'state' => 'Pendiente'
        ]);

        return response()->json([
            "message" => "Contrato registrado",
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function formatdateUTC($date){
       
        $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '', $date);
        $dateFormat =   Carbon::parse($date_clean)->format("Y-m-d h:i:s");
        return $dateFormat;
    }
}
