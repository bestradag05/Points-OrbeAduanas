<?php

namespace App\Http\Controllers;

use App\Models\AdditionalPoints;
use App\Models\ConceptCustoms;
use App\Models\Concepts;
use App\Models\Custom;
use App\Models\Customer;
use App\Models\Insurance;
use App\Models\Modality;
use App\Models\TypeShipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\PdfToText\Pdf;
use stdClass;

class CustomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Listar aduanas

        $customs = Custom::all()->load('routing.personal', 'modality');


        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Modalidad',
            'Estado',
            'Acciones'
        ];



        return view("custom/list-custom", compact("customs", "heads"));
    }

    public function getCustomPending()
    {

        //Listar aduanas

        $customs = Custom::where('state', 'Pendiente')->get()->load('routing.personal', 'modality');

        $heads = [
            '#',
            'N° Operacion',
            'Asesor',
            'Modalidad',
            'Estado',
            'Acciones'
        ];


        return view("custom/pending-list-custom", compact("customs", "heads"));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Redireccion al formulario para crear una aduana


        $customers = Customer::all();
        $type_shipments = TypeShipment::all();
        $modalitys = Modality::all();

        return view("custom/register-custom", compact('customers', 'type_shipments', 'modalitys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $concepts = json_decode($request->concepts);

        $custom = $this->createOrUpdateCustoms($request);

        $insurance = $this->createOrUpdateInsurance($request, $custom);

        if ($insurance) {
            $concepts = $this->updateConceptInsurance($concepts, $custom, $request);
        }


        $this->syncCustomsConcepts($custom, $concepts);

        return redirect('commercial/quote/' . $custom->commercial_quote->id . '/detail');
    }


    private function createOrUpdateCustoms(Request $request, $id = null)
    {
        $custom = $id ? Custom::findOrFail($id) : new Custom();

        $custom->fill([
            'id_modality' => $request->modality,
            'customs_taxes' => $request->customs_taxes,
            'customs_perception' => $request->customs_perception,
            'total_custom' => $request->totalCustom,
            'state' => $request->state ?? 'Pendiente',
            'nro_quote_commercial' => $request->nro_quote_commercial,
        ]);

        $custom->save();


        return $custom;
    }


    private function createOrUpdateInsurance(Request $request, Custom $custom)
    {

        if (!$request->state_insurance) {

            //Eliminamos el seguro vinculado al flete si existe.
            Insurance::where('id_insurable_service', $custom->id)
                ->where('model_insurable_service', Custom::class)->delete();

            return null; // Si no se envía el seguro, no se hace nada
        }

        $sales_price = $request->value_insurance + $request->insurance_added;

        $insurance = Insurance::where('id_insurable_service', $custom->id)
            ->where('model_insurable_service', Custom::class)
            ->first();

        if ($insurance) {
            // Si el seguro existe, actualizarlo
            $insurance->update([
                'insurance_value' => $request->value_insurance,
                'insurance_value_added' => $request->insurance_added,
                'insurance_sale' => $sales_price,
                'sales_value' => $sales_price * 0.18,
                'sales_price' => $sales_price * 1.18,
                'additional_points' => $request->insurance_points,
                'id_type_insurance' =>  $request->type_insurance,
                'state' => 'Pendiente',
            ]);
        } else {
            // Si no existe, crearlo
            $insurance = Insurance::create([
                'insurance_value' => $request->value_insurance,
                'insurance_value_added' => $request->insurance_added,
                'insurance_sale' => $sales_price,
                'sales_value' => $sales_price * 0.18,
                'sales_price' => $sales_price * 1.18,
                'additional_points' => $request->insurance_points,
                'id_type_insurance' =>  $request->type_insurance,
                'name_service' => 'Aduana',
                'id_insurable_service' => $custom->id,
                'model_insurable_service' => Custom::class,
                'state' => 'Pendiente'
            ]);

            $custom->insurance()->save($insurance);
        }


        return $insurance;
    }



    private function updateConceptInsurance($concepts, $freight, $request)
    {

        $arrayConcepts = (array) $concepts; //convertimos array los conceptos
        $lastKey = array_key_last($arrayConcepts); // obtenemos el ultimo indice
        $key = $lastKey + 1; // agregamos al ultimo indice par acrear el concepto de seguro


        // Buscar el concepto en la base de datos
        /*   $concept = Concepts::where('name', 'SEGURO')
            ->where('id_type_shipment', $freight->routing->type_shipment->id)
            ->whereHas('typeService', function ($query) {
                $query->where('name', 'Flete');  // Segunda condición: Filtrar por name del tipo de servicio
            })
            ->first(); */


        $concept = Concepts::where('name', 'SEGURO')
            ->where('id_type_shipment', $freight->commercial_quote->type_shipment->id)
            ->whereHas('typeService', function ($query) {
                $query->where('name', 'Flete');  // Segunda condición: Filtrar por name del tipo de servicio
            })
            ->first();

        // Crear o actualizar el objeto del seguro
        $insuranceObject = new stdClass();
        $insuranceObject->id = $concept->id;
        $insuranceObject->name = 'SEGURO';
        $insuranceObject->value = $request->value_insurance;
        $insuranceObject->added = $request->insurance_added;
        $insuranceObject->pa = $request->insurance_points;

        // Guardar el concepto actualizado en el array
        $concepts[$key] = $insuranceObject;


        return $concepts;
    }


    private function syncCustomsConcepts($custom, $concepts)
    {
        // Eliminar los conceptos previos si estamos actualizando, pero antes 
        $conceptsCustom = ConceptCustoms::where('id_customs', $custom->id)->get(); // cuando eliminamos el concepto se elimina el additional_point relacionado en cascada

        if ($conceptsCustom) {
            foreach ($conceptsCustom as $concept) {
                $concept->additional_point()->delete();
                $concept->forceDelete(); // Esto elimina el ConceptFreight definitivamente
            }
        }

        // Relacionamos los nuevos conceptos con el flete
        foreach ($concepts as $concept) {

            $total = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);
            $net_amount = $total / 1.18;
            $igv = $total - $net_amount;

            $conceptCustom = ConceptCustoms::create([
                'id_concepts' => $concept->id, // ID del concepto relacionado
                'id_customs' => $custom->id, // Clave foránea al modelo Freight
                'value_concept' => $this->parseDouble($concept->value),
                'added_value' => $this->parseDouble($concept->added),
                'net_amount' => $net_amount,
                'igv' => $igv,
                'total' => $total,
                'additional_points' => isset($concept->pa) ? $concept->pa : 0,
            ]);
            // Si hay puntos adicionales, ejecutamos la función
            if (isset($concept->pa)) {
                $ne_amount = $this->parseDouble($concept->value) + $this->parseDouble($concept->added);
                $this->add_aditionals_point($conceptCustom, $ne_amount);
            }
        }
    }


    public function add_aditionals_point($conceptCustom,  $ne_amount = null, $igv = null, $total = null)
    {

        $additional_point = AdditionalPoints::create([
            'type_of_service' => $conceptCustom->concepts->name,
            'amount' => $ne_amount,
            'points' => $conceptCustom->additional_points,
            'id_additional_concept_service' => $conceptCustom->id,
            'model_additional_concept_service' => $conceptCustom::class,
            'additional_type' => 'AD-ADUANA',
            'state' => 'Pendiente'
        ]);


        $conceptCustom->additional_point()->save($additional_point);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mostamos el formulario para completar 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Obtenemos el registro que se va editar

        $custom = Custom::find($id)->load('modality');

        return view('custom/edit-custom', compact('custom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Se actualiza la aduana

        $this->validateForm($request, $id);

        $custom = Custom::find($id);
        $request['cif_value'] = $this->parseDouble($request->cif_value);
        $request['state'] = "Generado";


        $dateRegisterFormat = Carbon::createFromFormat('d/m/Y', $request['date_register'])->toDateString();
        $request['date_register'] = $dateRegisterFormat;


        if ($request->regularization_date != '' && $request->regularization_date != 'NO REQUIERE') {

            $dateRegularizationFormat = Carbon::createFromFormat('d/m/Y', $request->regularization_date)->toDateString();
            $request['regularization_date'] = $dateRegularizationFormat;
        } else {
            $request['regularization_date'] = 'Pendiente';
        }

        $custom->fill($request->all());
        $custom->save();

        return redirect('custom');
    }


    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /*     public function loadDocument(Request $request){

        if (!$request->hasFile('doc_custom')) {
            return response()->json(['mensaje' => 'No se ha proporcionado un archivo PDF'], 400);
        }

        // Obtener el archivo PDF de la solicitud
        $pdfFile = $request->file('doc_custom');

    
        $pdfFileName = uniqid() . '.' . $pdfFile->getClientOriginalExtension();

        // Mover el archivo PDF a la carpeta temporal
        $pdfFile->storeAs('pdf_temp', $pdfFileName);

        $textoCompleto = Pdf::getText('pdf/'.$pdfFileName, 'C:\Program Files\Git\mingw64\bin/pdftotext');
        
        $posicionInicio = strpos($textoCompleto, utf8_decode('No Declaración'));


        if ($posicionInicio !== false) {
            // Avanzar la posición de inicio a la posición justo después de la palabra "No Declaración"
            $posicionInicio += strlen('No Declaración ');
        
            // Buscar la posición del próximo salto de línea después de la posición de inicio
            $posicionSaltoLinea = strpos($textoCompleto, "\r\n", $posicionInicio);
        
            if ($posicionSaltoLinea !== false) {
                // Extraer el texto que sigue después de la palabra "No Declaración" hasta el próximo salto de línea
                $textoDespues = substr($textoCompleto, $posicionInicio, $posicionSaltoLinea - $posicionInicio);
        
    
            } else {
                echo "No se encontró el próximo salto de línea después de la palabra 'No Declaración'.";
            }
        } else {
            echo "No se encontró la palabra 'No Declaración' en el texto.";
        }

        return false;
    }
 */
    public function validateForm($request, $id)
    {
        $request->validate([
            'nro_orde' => 'required|string|unique:custom,nro_orde,' . $id,
            'nro_dua' => 'required|string|unique:custom,nro_dua,' . $id,
            'nro_dam' => 'string|unique:custom,nro_dam,' . $id,
            'date_register' => 'required|string',
            'cif_value' => 'required',
            'channel' => 'required|string',
            'nro_bl' => 'required|string',
        ]);
    }
}
