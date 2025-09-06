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


        /* Currencies */

        Currency::create(['badge' => 'Dólar estadounidense', 'abbreviation' => 'USD', 'symbol' => '$']);
        Currency::create(['badge' => 'Sol Peruano', 'abbreviation' => 'PEN', 'symbol' => 'S/']);
        Currency::create(['badge' => 'Libra Esterlina', 'abbreviation' => 'GBP', 'symbol' => '£']);
        Currency::create(['badge' => 'Euro', 'abbreviation' => 'EUR', 'symbol' => '€']);


        /* Commissions */

        Commission::create(['name' => 'PRICING', 'default_amount' => '10', 'description' => 'COMISION DE PRICING POR CARGA CERRADA']);
        Commission::create(['name' => 'OPERACIONES', 'default_amount' => '10', 'description' => 'COMISION DE OPERACIONES POR CARGA CERRADA']);
        Commission::create(['name' => 'GASTOS ADMINISTRATIVOS', 'default_amount' => '10', 'description' => 'COMISION DE ADMINISTRACION POR CARGA CERRADA']);


        /* TypeInsurance */
        $insuranceA = TypeInsurance::create(['name' => 'Seguro A', 'state' => 'Activo']);
        $insuranceB = TypeInsurance::create(['name' => 'Seguro B', 'state' => 'Activo']);

        /* Rate Insurance */
        InsuranceRates::create(['insurance_type_id' => $insuranceA->id, 'shipment_type_description' => 'Marítima', 'min_value' => 30000, 'fixed_cost' => 65, 'percentage' => 0.65]);
        InsuranceRates::create(['insurance_type_id' => $insuranceA->id, 'shipment_type_description' => 'Aérea', 'min_value' => 30000, 'fixed_cost' => 55, 'percentage' => 0.55]);
        InsuranceRates::create(['insurance_type_id' => $insuranceB->id, 'shipment_type_description' => 'Marítima', 'min_value' => 30000, 'fixed_cost' => 45, 'percentage' => 0.25]);
        InsuranceRates::create(['insurance_type_id' => $insuranceB->id, 'shipment_type_description' => 'Aérea', 'min_value' => 30000, 'fixed_cost' => 45, 'percentage' => 0.25]);

    }
}
