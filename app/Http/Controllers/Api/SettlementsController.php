<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Settlements;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettlementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $exist_personal = Settlements::where("nro_order", $request->nro_order)->first();


        if ($exist_personal) {
            return response()->json([
                "message" => "Ya existe una liquidacion con este numero de orden"
            ], 403);
        }


        // "Fri Oct 08 1993 00:00:00 GMT-0500 (hora estándar de Perú)"
        // Eliminar la parte de la zona horaria (GMT-0500 y entre paréntesis)
        $date_clean = preg_replace('/\(.*\)|[A-Z]{3}-\d{4}/', '', $request->date);

        $request->date =  Carbon::parse($date_clean)->format("Y-m-d");


        $settlement = Settlements::create([
            'nro_order' => $request->nro_order,
            'date' => $request->date,
            'customer' => $request->customer,
            'gia_bl' => $request->gia_bl,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'cif_value' => $request->cif_value,
            'number_of_packages' => $request->number_of_packages,
            'type_of_shipment' => $request->type_of_shipment,
            'regime' => $request->regime,
            'dua_number' => $request->dua_number,
            'channel' => $request->channel
        ]);



        foreach ($request->vauchers as  $vaucher) {

            if ($vaucher['file']) {

                $path = Storage::putFile("settlements/".$settlement->nro_order, $vaucher['file']);
            }
            
            $voucher = new Voucher();

            // Asignar los valores de cada campo
            $voucher->ruc = $vaucher['ruc'];
            $voucher->name_businessname = $vaucher['company_name'];
            $voucher->serial_number = $vaucher['serial_number'];
            $voucher->sub_total = $vaucher['subTotal'];
            $voucher->igv = $vaucher['igv'];
            $voucher->total_amount = $vaucher['total_voucher'];
            $voucher->type_of_receipt = $vaucher['receipt_type'];
            $voucher->document_url  = $path;
            $voucher->id_settlement = $settlement->id;

            // Guardar en la base de datos
            $voucher->save();
        }


        return response()->json([
            "message" => "Se creo una nueva liquidación",
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
}
