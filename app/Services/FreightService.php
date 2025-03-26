<?php

namespace App\Services;

use App\Models\Concepts;
use App\Models\Freight;
use App\Models\TypeInsurance;

class FreightService
{


    public function editFreight(string $id)
    {

        $freight = Freight::with('concepts.concept_freight.additional_point')->find($id);

        $commercial_quote = $freight->commercial_quote;
        $value_freight = 0;
        $insurance = null;

        if ($freight->insurance()->exists()) {
            $insurance = $freight->insurance;
        }

        $quote = $freight->quoteFreight()->where('state', 'Aceptado')->first();
        $type_insurace = TypeInsurance::all();
        $concepts = Concepts::all();

        $conceptFreight = null;

        foreach ($concepts as $concept) {

            if ($freight->commercial_quote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Flete' && $concept->name === 'OCEAN FREIGHT') {
                $conceptFreight = $concept;
            }

            if ($freight->commercial_quote->type_shipment->id === $concept->id_type_shipment && $concept->typeService->name == 'Flete' && $concept->name === 'AIR FREIGHT') {
                $conceptFreight = $concept;
            }
        }

      
        return compact('freight', 'quote', 'type_insurace', 'concepts', 'conceptFreight', 'commercial_quote', 'insurance');

    }
}
