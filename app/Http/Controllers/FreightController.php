<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
use App\Models\ConceptFreight;
use App\Models\Concepts;
use App\Models\Freight;
use App\Models\Insurance;
use App\Models\QuoteFreight;
use App\Models\TypeInsurance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class FreightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $freights = Freight::all();


        $heads = [
            '#',
            'N° Operacion',
            'Asesor Comercial',
            'Utilidad a Orbe',
            'Estado',
            'Acciones'
        ];



        return view("freight/list-freight", compact("freights", "heads"));
    }


    public function getFreightPending()
    {

        $freights = Freight::where('state', 'Pendiente')->get()->load('routing.personal');


        $heads = [
            '#',
            'N° Operacion',
            'Asesor Comercial',
            'Utilidad a Orbe',
            'Estado',
            'Acciones'
        ];



        return view("freight/pending-list-freight", compact("freights", "heads"));
    }

    public function getFreightPersonal()
    {

        $personalId = Auth::user()->personal->id;

        // Verificar si el usuario es un Super-Admin
        if (Auth::user()->hasRole('Super-Admin')) {
            // Si es Super-Admin, obtener todos los routing
            $freights = Freight::with('quoteFreights')->get();
        } else {
            // Si no es Super-Admin, solo obtener los clientes que pertenecen al personal del usuario autenticado
            $freights = Freight::whereHas('routing', function ($query) use ($personalId) {
                $query->where('id_personal', $personalId);
            })->with('quoteFreights')->get();
        }


        $heads = [
            '#',
            'N° Operacion',
            'N° Cotizacion',
            'Utilidad a Orbe',
            'Valor del Flete',
            'Asesor Comercial',
            'Estado',
            'Acciones'
        ];



        return view("freight/list-freight-personal", compact("freights", "heads"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    public function createFreight($quoteId)
    {

        $quote = QuoteFreight::findOrFail($quoteId);
        $type_insurace = TypeInsurance::all();
        $concepts = Concepts::all();
        $conceptFreight = null;
        foreach ($concepts as $concept) {

            if ($concept->typeService->name == 'Flete' && $concept->name === 'OCEAN FREIGHT') {
                $conceptFreight = $concept;
            }
        }


        return view('freight.register-freight', compact('quote', 'type_insurace', 'concepts', 'conceptFreight'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //Convertimos el json a un objeto
        $concepts = json_decode($request->concepts);

        $freight = Freight::create([
            'value_freight' => $request->total,
            'value_utility' => $request->utility,
            'state' => 'Pendiente',
            'id_quote_freight' => $request->id_quote_freight,
            'nro_operation' => $request->nro_operation,
        ]);

        if ($request->state_insurance) {

            $sales_price = $request->value_insurance + $request->insurance_added;

            $insurance = Insurance::create([
                'insurance_value' => $request->value_insurance, // precio neto del seguro
                'insurance_value_added' => $request->insurance_added, // precio agregado del asesor
                'insurance_sale' => $sales_price, // Valor venta del seguro
                'sales_value' => $sales_price * 0.18, // valor venta prima (igv)
                'sales_price' => $sales_price * 1.18, // precio de venta
                'additional_points' => $request->insurance_points,
                'id_type_insurance' =>  $request->type_insurance,
                'name_service' => 'Flete',
                'id_insurable_service' => $freight->id,
                'model_insurable_service' => Freight::class,
                'state' => 'Pendiente'
            ]);

            $freight->insurance()->save($insurance);

            //Si existe seguro agregaremos el concepto de SEGURO a la tabla concepts_freight


            $arrayConcepts = (array) $concepts; //convertimos array los conceptos
            $lastKey = array_key_last($arrayConcepts); // obtenemos el ultimo indice
            $key = $lastKey + 1; // agregamos al ultimo indice par acrear el concepto de seguro

            $concept = Concepts::where('name', 'SEGURO')
                ->where('id_type_shipment', $freight->routing->type_shipment->id)
                ->whereHas('typeService', function ($query) {
                    $query->where('name', 'Flete');  // Segunda condición: Filtrar por name del tipo de servicio
                })
                ->first();

            //creamos el objeto del seguro
            $insuranceObject = new stdClass();

            $insuranceObject->id = $concept->id;
            $insuranceObject->name = 'SEGURO';
            $insuranceObject->value = $request->value_insurance;
            $insuranceObject->added = $request->insurance_added;
            $insuranceObject->pa = $request->insurance_points;


            $concepts->$key = $insuranceObject;
        }


        //Relacionamos los conceptos que tendra este flete

        foreach ($concepts as $concept) {
            $service = ConceptFreight::create([
                'id_concepts' => $concept->id, // ID del concepto relacionado
                'id_freight' => $freight->id, // Clave foránea al modelo Freight
                'value_concept' => $concept->value,
                'value_concept_added' => $concept->added,
                'total_value_concept' => $concept->value + $concept->added,
                'additional_points' => isset($concept->pa) ? $concept->pa : 0,
            ]);

            if (isset($concept->pa)) {

                $ne_amount = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);

                $this->add_aditionals_point($concept, $service, $ne_amount);
            }
        }

        return redirect('freight/personal');
    }


    public function add_aditionals_point($concept, $service,  $ne_amount = null, $igv = null, $total = null)
    {


        $additional_point = AdditionalPoints::create([
            'type_of_service' => $concept->name,
            'amount' => ($ne_amount != 0 && $ne_amount != null) ? $ne_amount : $this->parseDouble($concept->value) +  $this->parseDouble($concept->added),
            'igv' => $igv,
            'total' => $total,
            'points' => $concept->pa,
            'id_additional_concept_service' => $concept->id,
            'model_additional_concept_service' => $service::class,
            'additional_type' => ($service::class === 'App\Models\ConceptFreight') ? 'AD-FLETE' : 'AD-ADUANA',
            'state' => 'Pendiente'
        ]);


        $service->additional_point()->save($additional_point);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }



    public function getTemplateGeneratePointFreight(string $id)
    {
        // Obtenemos el registro que se va editar

        $freight = Freight::find($id);
        $value_freight = 0;

        /* $freight->load('concepts'); */

        foreach ($freight->concepts as $concept) {
            $value_freight += $concept->pivot->value_concept;
        }

        return view('freight/edit-point-freight', compact('freight', 'value_freight'));
    }

    public function updatePointFreight(Request $request, string $id)
    {
        $this->validateForm($request, $id);

        $freight = Freight::find($id);


        $dateRegisterFormat = Carbon::createFromFormat('d/m/Y', $request['edt'])->toDateString();
        $request['date_register'] = $dateRegisterFormat;

        $edtFormat = Carbon::createFromFormat('d/m/Y', $request['edt'])->toDateString();
        $request['edt'] = $edtFormat;

        $etaFormat = Carbon::createFromFormat('d/m/Y', $request['eta'])->toDateString();
        $request['eta'] = $etaFormat;

        $request['state'] = "Generado";

        $freight->fill($request->all());
        $freight->save();

        return redirect('freight');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Obtenemos el registro que se va editar

        $freight = Freight::with('concepts.concept_freight.additional_point')->find($id);
        $value_freight = 0;


        if ($freight->insurance()->exists()) {
            $insurance = $freight->insurance;
        }

        $quote = $freight->quoteFreights()->where('state', 'Aceptada')->first();
        $type_insurace = TypeInsurance::all();
        $concepts = Concepts::all();

        $conceptFreight = null;
        foreach ($concepts as $concept) {

            if ($concept->typeService->name == 'Flete' && $concept->name === 'OCEAN FREIGHT') {
                $conceptFreight = $concept;
            }
        }

        foreach ($freight->concepts as $concept) {
            $value_freight += $concept->pivot->value_concept;
        }

        return view('freight/edit-freight', compact('freight', 'value_freight', 'quote', 'type_insurace', 'concepts', 'conceptFreight',  'insurance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
   
        //Convertimos el json a un objeto
        $concepts = json_decode($request->concepts);

        dd($concepts);

        $freight = Freight::create([
            'value_freight' => $request->total,
            'value_utility' => $request->utility,
            'state' => 'Pendiente',
            'id_quote_freight' => $request->id_quote_freight,
            'nro_operation' => $request->nro_operation,
        ]);

        if ($request->state_insurance) {

            $sales_price = $request->value_insurance + $request->insurance_added;

            $insurance = Insurance::create([
                'insurance_value' => $request->value_insurance, // precio neto del seguro
                'insurance_value_added' => $request->insurance_added, // precio agregado del asesor
                'insurance_sale' => $sales_price, // Valor venta del seguro
                'sales_value' => $sales_price * 0.18, // valor venta prima (igv)
                'sales_price' => $sales_price * 1.18, // precio de venta
                'additional_points' => $request->insurance_points,
                'id_type_insurance' =>  $request->type_insurance,
                'name_service' => 'Flete',
                'id_insurable_service' => $freight->id,
                'model_insurable_service' => Freight::class,
                'state' => 'Pendiente'
            ]);

            $freight->insurance()->save($insurance);

            //Si existe seguro agregaremos el concepto de SEGURO a la tabla concepts_freight


            $arrayConcepts = (array) $concepts; //convertimos array los conceptos
            $lastKey = array_key_last($arrayConcepts); // obtenemos el ultimo indice
            $key = $lastKey + 1; // agregamos al ultimo indice par acrear el concepto de seguro

            $concept = Concepts::where('name', 'SEGURO')
                ->where('id_type_shipment', $freight->routing->type_shipment->id)
                ->whereHas('typeService', function ($query) {
                    $query->where('name', 'Flete');  // Segunda condición: Filtrar por name del tipo de servicio
                })
                ->first();

            //creamos el objeto del seguro
            $insuranceObject = new stdClass();

            $insuranceObject->id = $concept->id;
            $insuranceObject->name = 'SEGURO';
            $insuranceObject->value = $request->value_insurance;
            $insuranceObject->added = $request->insurance_added;
            $insuranceObject->pa = $request->insurance_points;


            $concepts->$key = $insuranceObject;
        }


        //Relacionamos los conceptos que tendra este flete

        foreach ($concepts as $concept) {
            $service = ConceptFreight::create([
                'id_concepts' => $concept->id, // ID del concepto relacionado
                'id_freight' => $freight->id, // Clave foránea al modelo Freight
                'value_concept' => $concept->value,
                'value_concept_added' => $concept->added,
                'total_value_concept' => $concept->value + $concept->added,
                'additional_points' => isset($concept->pa) ? $concept->pa : 0,
            ]);

            if (isset($concept->pa)) {

                $ne_amount = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);

                $this->add_aditionals_point($concept, $service, $ne_amount);
            }
        }

        return redirect('freight/personal');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function validateForm($request, $id)
    {
        $request->validate([
            'roi' => 'required|string|unique:freight,roi,' . $id
        ]);
    }



    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
    }
}
