<?php

namespace App\Services;

use App\Models\AdditionalPoints;
use App\Models\CommercialQuote;
use App\Models\ConceptCustoms;
use App\Models\Concept;
use App\Models\Custom;
use App\Models\Insurance;
use App\Models\Modality;
use App\Models\TypeInsurance;
use App\Models\TypeService;
use App\Models\TypeShipment;
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
        $typeShipments = TypeShipment::all();
        $typeServices = TypeService::all();

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


        return  compact('custom', 'commercialQuote', 'modalitys', 'insurance', 'type_insurace', 'concepts', 'filteredConcepts', 'typeShipments', 'typeServices');
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

        $commercial = CommercialQuote::where('nro_quote_commercial', $request->nro_quote_commercial)->first();

        $typeService = TypeService::where('name', 'Aduanas')->first();

        if ($commercial && $typeService) {
            if ($id) {
               
                $commercial->typeService()->syncWithoutDetaching([$typeService->id]);
            } else {
                $commercial->typeService()->attach($typeService->id);
            }
        }

        $custom->fill([
            'id_modality' => $request->modality,
            'customs_taxes' => $this->parseDouble($request->customs_taxes),
            'customs_perception' => $this->parseDouble($request->customs_perception),
            'advalorem_percentage' => $this->parseDouble($request->advalorem_percentage),
            'perception_percentage' => $this->parseDouble($request->perception_percentage),
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


    public function calculateTaxescustom($comercialQuote)
    {
        $customs_taxes = new stdClass();

        $customs_taxes_value = $comercialQuote->cif_value * 0.215;
        $customs_perception_value = ($comercialQuote->cif_value + $customs_taxes_value) * 0.035;

        $customs_taxes->customs_taxes = number_format($customs_taxes_value, 2);
        $customs_taxes->customs_perception = number_format($customs_perception_value, 2);

        return $customs_taxes;
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
                'observation' => $concept->observation,
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
