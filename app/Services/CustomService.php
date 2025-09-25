<?php

namespace App\Services;

use App\Models\AdditionalPoints;
use App\Models\ConceptCustoms;
use App\Models\Concept;
use App\Models\Custom;
use App\Models\Insurance;
use App\Models\Modality;
use App\Models\TypeInsurance;
use Illuminate\Http\Request;
use stdClass;

class CustomService
{

    public function storeCustom($request)
    {

        $concepts = json_decode($request->concepts);

        $custom = $this->createOrUpdateCustoms($request);

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

        $commercialQuote = $custom->commercial_quote;


        $modalitys = Modality::all();
        $type_insurace = TypeInsurance::with('insuranceRate')->get();
        $concepts = Concept::all();



        $customs_agency = 0;
        $pleasantOperatives = 35;

        if (isset($commercialQuote->load_value)) {
            if ($commercialQuote->load_value >= 23000) {
                $customs_agency = $commercialQuote->load_value * 0.0045;
            } else {
                $customs_agency = 100;
            }
        }

        // Filtrar los conceptos de "GASTOS OPERATIVOS" y "AGENCIAMIENTO DE ADUANAS"
        $filteredConcepts = [];
        foreach ($concepts as $concept) {
            if (($concept->name === 'GASTOS OPERATIVOS' || $concept->name === 'AGENCIAMIENTO DE ADUANAS') && $commercialQuote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Aduanas') {
                $conceptData = [
                    'id' => $concept->id,
                    'name' => $concept->name,  // Nombre del concepto
                    'value' => 0  // Valor inicial
                ];

                if ($concept->name === 'AGENCIAMIENTO DE ADUANAS') {
                    $conceptData['value'] = $customs_agency;  // Asignamos el precio calculado
                } elseif ($concept->name === 'GASTOS OPERATIVOS') {
                    $conceptData['value'] = $pleasantOperatives;  // Valor fijo para "GASTOS OPERATIVOS"
                }

                $filteredConcepts[] = $conceptData;  // Agregamos al arreglo final
            }
        }


        return  compact('custom', 'commercialQuote', 'modalitys', 'insurance', 'type_insurace', 'concepts', 'filteredConcepts');
    }


    public function updateCustom($request, $id)
    {
        $concepts = json_decode($request->concepts);

        $custom = $this->createOrUpdateCustoms($request, $id);

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
            'value_utility' => $this->parseDouble($request->value_utility),
            'net_amount' => $this->parseDouble($request->custom_insurance),
            'sub_total_value_sale' => $this->parseDouble($request->sub_total_value_sale),
            'igv' => $this->parseDouble($request->igv),
            'value_sale' => $this->parseDouble($request->value_sale),
            'profit' => $request->profit,
            'state' => $request->state ?? 'Pendiente',
            'nro_quote_commercial' => $request->nro_quote_commercial,
        ]);

        $custom->save();

        // Ahora accedemos a la relación y actualizamos el cif_value en CommercialQuote
        if ($custom->commercial_quote) {  // Verifica si la relación existe
            $commercialQuote = $custom->commercial_quote;
            $commercialQuote->cif_value = $this->parseDouble($request->cif_value);
            $commercialQuote->save();  // Guardar los cambios en CommercialQuote
        }

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

        $insurance = Insurance::where('id_insurable_service', $custom->id)
            ->where('model_insurable_service', Custom::class)
            ->first();

        if ($insurance) {
            // Si el seguro existe, actualizarlo
            $insurance->update([
                'insurance_value' => $request->value_insurance,
                'insurance_sales_value' => $request->insurance_sales_value,
                'id_type_insurance' =>  $request->type_insurance,
                'state' => 'Pendiente',
            ]);
        } else {
            // Si no existe, crearlo
            $insurance = Insurance::create([
                'insurance_value' => $request->value_insurance,
                'insurance_sales_value' => $request->insurance_sales_value,
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



    private function updateConceptInsurance($concepts, $custom, $request)
    {

        $arrayConcepts = (array) $concepts; //convertimos array los conceptos
        $lastKey = array_key_last($arrayConcepts); // obtenemos el ultimo indice
        $key = $lastKey + 1; // agregamos al ultimo indice par acrear el concepto de seguro
        $concept = Concept::where('name', 'SEGURO')
            ->where('id_type_shipment', $custom->commercial_quote->type_shipment->id)
            ->whereHas('typeService', function ($query) {
                $query->where('name', 'Aduanas');  // Segunda condición: Filtrar por name del tipo de servicio
            })
            ->first();


        // Crear o actualizar el objeto del seguro
        $insuranceObject = new stdClass();
        $insuranceObject->id = $concept->id;
        $insuranceObject->name = $concept->name;
        $insuranceObject->value = $request->value_insurance;
        $insuranceObject->value_sale = $request->insurance_sales_value;

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
                $concept->forceDelete(); // Esto elimina el ConceptFreight definitivamente
            }
        }

        // Relacionamos los nuevos conceptos con el flete
        foreach ($concepts as $concept) {
            /* $total = $this->parseDouble($concept->value) + $this->parseDouble($concept->added); */
            /* $net_amount = $total / 1.18;
            $igv = $total - $net_amount; */

            ConceptCustoms::create([
                'concepts_id' => $concept->id, // ID del concepto relacionado
                'id_customs' => $custom->id, // Clave foránea al modelo Freight
                'value_concept' => $this->parseDouble($concept->value),
                'value_sale' => $this->parseDouble($concept->value_sale),
            ]);
        }
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
