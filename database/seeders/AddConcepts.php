<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\Concept;
use App\Models\Currency;
use App\Models\InsuranceRates;
use App\Models\TypeInsurance;
use Illuminate\Database\Seeder;

class AddConcepts extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Conceptos para Aduana - Maritimo */
        Concept::create(['name' => 'AGENCIAMIENTO DE ADUANAS', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'GATE-IN', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'GASTOS OPERATIVOS', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'GASTOS PORTUARIOS', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'SEGURO', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'TRÁMITE ADUANERO MARÍTIMO', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'DESPACHO ADUANERO MARÍTIMO', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'INSPECCIÓN DE CARGA MARÍTIMA', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'CERTIFICADO DE ORIGEN MARÍTIMO', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'REGULARIZACIÓN DE DOCUMENTOS ADUANEROS MARÍTIMOS', 'id_type_shipment' => 8, 'id_type_service' => 1]);

        /* Conceptos para Flete - Maritimo */
        Concept::create(['name' => 'OCEAN FREIGHT', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'F.S.C', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'THC', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'SEGURO', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'FLETE MARÍTIMO ESTÁNDAR', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'FLETE MARÍTIMO EXPEDITO', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'COSTO DE FLETE MARÍTIMO', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'MANIOBRAS EN EL PUERTO', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'GASTOS EN EL PUERTO', 'id_type_shipment' => 8, 'id_type_service' => 2]);

        //Conceptos para Transporte - Maritimo
        Concept::create(['name' => 'TRANSPORTE', 'id_type_shipment' => 8, 'id_type_service' => 3]);
        Concept::create(['name' => 'CUADRILLA', 'id_type_shipment' => 8, 'id_type_service' => 3]);
        Concept::create(['name' => 'RESGUARDO', 'id_type_shipment' => 8, 'id_type_service' => 3]);
        Concept::create(['name' => 'PATO', 'id_type_shipment' => 8, 'id_type_service' => 3]);
        Concept::create(['name' => 'CARGA Y DESCARGA MARÍTIMA', 'id_type_shipment' => 8, 'id_type_service' => 3]);
        Concept::create(['name' => 'SERVICIO DE TRANSPORTE MARÍTIMO', 'id_type_shipment' => 8, 'id_type_service' => 3]);
        Concept::create(['name' => 'LOGÍSTICA DE TRANSPORTE MARÍTIMO', 'id_type_shipment' => 8, 'id_type_service' => 3]);
        Concept::create(['name' => 'COSTOS DE MANIOBRAS MARÍTIMAS', 'id_type_shipment' => 8, 'id_type_service' => 3]);

        //Conceptos para Aduana - Aereo
        Concept::create(['name' => 'AGENCIAMIENTO DE ADUANAS', 'id_type_shipment' => 21, 'id_type_service' => 1]);
        Concept::create(['name' => 'GASTOS OPERATIVOS', 'id_type_shipment' => 21, 'id_type_service' => 1]);
        Concept::create(['name' => 'SEGURO', 'id_type_shipment' => 21, 'id_type_service' => 1]);
        Concept::create(['name' => 'TRÁMITE ADUANERO AÉREO', 'id_type_shipment' => 21, 'id_type_service' => 1]);
        Concept::create(['name' => 'DESPACHO ADUANERO AÉREO', 'id_type_shipment' => 21, 'id_type_service' => 1]);
        Concept::create(['name' => 'CERTIFICADO DE ORIGEN AÉREO', 'id_type_shipment' => 21, 'id_type_service' => 1]);

        //Conceptos para Flete - Aereo
        Concept::create(['name' => 'AIR FREIGHT', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concept::create(['name' => 'DELIVERY AIRPO', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concept::create(['name' => 'HANDLING', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concept::create(['name' => 'TRANSMISION', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concept::create(['name' => 'SEGURO', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concept::create(['name' => 'FLETE AÉREO ESTÁNDAR', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concept::create(['name' => 'FLETE AÉREO URGENTE', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concept::create(['name' => 'COSTO DE FLETE AÉREO', 'id_type_shipment' => 21, 'id_type_service' => 2]);

        //Conceptos para Transporte -Aereo
        Concept::create(['name' => 'TRANSPORTE', 'id_type_shipment' => 21, 'id_type_service' => 3]);
        Concept::create(['name' => 'CUADRILLA', 'id_type_shipment' => 21, 'id_type_service' => 3]);
        Concept::create(['name' => 'PATO', 'id_type_shipment' => 21, 'id_type_service' => 3]);
        Concept::create(['name' => 'CARGA Y DESCARGA AÉREA', 'id_type_shipment' => 21, 'id_type_service' => 3]);
        Concept::create(['name' => 'SERVICIO DE TRANSPORTE AÉREO', 'id_type_shipment' => 21, 'id_type_service' => 3]);

    }
}
