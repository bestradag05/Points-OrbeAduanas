<?php

namespace App\Services;

use App\Models\AdditionalPoints;
use App\Models\CommercialQuote;
use App\Models\ConceptCustoms;
use App\Models\ConceptFreight;
use App\Models\Concepts;
use App\Models\Custom;
use App\Models\Freight;
use App\Models\Insurance;
use App\Models\Modality;
use App\Models\QuoteFreight;
use App\Models\TypeInsurance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class CustomService
{

    public function storeCustom($request){

        $concepts = json_decode($request->concepts);

        $custom = $this->createOrUpdateCustoms($request);

        $insurance = $this->createOrUpdateInsurance($request, $custom);

        if ($insurance) {
            $concepts = $this->updateConceptInsurance($concepts, $custom, $request);
        }


        $this->syncCustomsConcepts($custom, $concepts);


        return $custom;

    }

    public function editCustom($id)
    {
        // Obtenemos el registro que se va editar

        $custom = Custom::with('concepts')->find($id);

        $insurance = null;

        if ($custom->insurance()->exists()) {
            $insurance = $custom->insurance;
        }

        $commercial_quote = $custom->commercial_quote;

        //Verificamos si tiene flete para calcular los impuestos: 
        if ($commercial_quote->freight()->exists()) {
           
            //Calculamos impuestos para la aduana si es que lo llega a usar.
            $customs_taxes = $this->calculateCustomTaxes($commercial_quote);
           
        }

        $modalitys = Modality::all();
        $type_insurace = TypeInsurance::all();
        $concepts = Concepts::all();

        $conceptCustom = null;

        foreach ($concepts as $concept) {


            if ($custom->commercial_quote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Aduanas' && $concept->name === 'AGENCIAMIENTO DE ADUANAS') {
                $conceptCustom = $concept;
            }

 
        }


        return  compact('custom', 'commercial_quote', 'modalitys', 'insurance', 'type_insurace', 'concepts', 'customs_taxes' , 'conceptCustom');
    }


    public function updateCustom($request, $id)
    {
        $concepts = json_decode($request->concepts);

        $custom = $this->createOrUpdateCustoms($request, $id);

        $insurance = $this->createOrUpdateInsurance($request, $custom);

        if ($insurance) {
            $concepts = $this->updateConceptInsurance($concepts, $custom, $request);
        }


        $this->syncCustomsConcepts($custom, $concepts);

        return $custom;
        

    }


    private function createOrUpdateCustoms($request, $id = null)
    {
        $custom = $id ? Custom::findOrFail($id) : new Custom();

        $custom->fill([
            'id_modality' => $request->modality,
            'customs_taxes' => $this->parseDouble($request->customs_taxes),
            'customs_perception' => $this->parseDouble($request->customs_perception),
            'total_custom' => $this->parseDouble($request->totalCustom),
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

    public function parseDouble($num)
    {

        $valorDecimal = (float)str_replace(',', '', $num);

        return $valorDecimal;
    }


    public function calculateCustomTaxes($commercial_quote)
    {
        $customs_taxes = new stdClass();

        $customs_taxes_value = $commercial_quote->cif_value * 0.18;
        $customs_perception_value = ($commercial_quote->cif_value + $customs_taxes_value) * 0.035;

        $customs_taxes->customs_taxes = number_format($customs_taxes_value, 2);
        $customs_taxes->customs_perception = number_format($customs_perception_value, 2);

        return $customs_taxes;

    }
}
