<?php

namespace App\Http\Controllers;

use App\Models\InsuranceRates;
use App\Models\TypeInsurance;
use App\Models\TypeShipment;
use Illuminate\Http\Request;

class InsuranceRatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insuranceRates = InsuranceRates::all();

        $heads = [
            '#',
            'Tipo de seguro',
            'Tipo de embarque',
            'Valor max asegurado',
            'Monto fijo',
            'Porcentaje',
            'Acciones'
        ];


        return view("insurances/insurance_rates/list-insurance-rates", compact("insuranceRates", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $insuranceTypes = TypeInsurance::all();
        $typeShipments = TypeShipment::select('description')->distinct()->get();

        return view('insurances/insurance_rates.register-insurance-rates', compact('insuranceTypes', 'typeShipments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateForm($request,  null);


        $existingRate = InsuranceRates::where('insurance_type_id', $request->insurance_type_id)
            ->where('shipment_type_description', $request->shipment_type_description)
            ->exists();

        if ($existingRate) {
            return back()->with('error', 'Ya existe una tarifa para este tipo de seguro y embarque.');
        }

        InsuranceRates::create($request->all());

        return redirect('insurance_rates')->with('success', 'Se agrego la tarifa');
    }

    /**
     * Display the specified resource.
     */
    public function show(InsuranceRates $insurance_rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InsuranceRates $insurance_rate)
    {

        $insuranceTypes = TypeInsurance::all();
        $typeShipments = TypeShipment::select('description')->distinct()->get();

        return view('insurances/insurance_rates.edit-insurance-rates', compact('insurance_rate', 'insuranceTypes', 'typeShipments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InsuranceRates $insurance_rate)
    {
        $this->validateForm($request, null);


        $existingRate = InsuranceRates::where('insurance_type_id', $request->insurance_type_id)
            ->where('shipment_type_description', $request->shipment_type_description)
            ->where('id', '!=', $insurance_rate->id)
            ->exists();

        if ($existingRate) {
            return back()->with('error', 'Ya existe una tarifa para este tipo de seguro y embarque.');
        }


        $insurance_rate->update($request->all());

        return redirect('insurance_rates')->with('success', 'Se actualizo la tarifa');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InsuranceRates $insurance_rate)
    {
        // Verificar si existe
        if ($insurance_rate) {
            // Eliminar el registro
            $insurance_rate->delete();

            return redirect()->route('insurance_rates.index')->with('success', 'Tarifa de seguro eliminada con éxito.');
        } else {
            return redirect()->route('insurance_rates.index')->with('error', 'No se encontró la tarifa de seguro.');
        }
    }

    public function validateForm($request, $id)
    {
        $request->validate([
            'insurance_type_id' => 'required|integer|exists:type_insurance,id',
            'shipment_type_description' => 'required|string',
            'min_value' => 'required|numeric',
            'fixed_cost' => 'required|numeric',
            'percentage' => 'required|numeric',
        ]);
    }
}
