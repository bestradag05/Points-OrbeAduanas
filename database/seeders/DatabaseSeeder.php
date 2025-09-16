<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Airline;
use App\Models\CommercialQuote;
use App\Models\Commission;
use App\Models\Concept;
use App\Models\Container;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerSupplierDocument;
use App\Models\Incoterms;
use App\Models\InsuranceRates;
use App\Models\Modality;
use App\Models\PackingType;
use App\Models\Personal;
use App\Models\PersonalDocument;
use App\Models\Regime;
use App\Models\Routing;
use App\Models\Shipper;
use App\Models\ShippingCompany;
use App\Models\Supplier;
use App\Models\TypeContainer;
use App\Models\TypeInsurance;
use App\Models\TypeLoad;
use App\Models\TypeService;
use App\Models\TypeShipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Current;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //Crear un rol de Super-Admin
        $role = Role::create(['guard_name' => 'web', 'name' => 'Super-Admin']);


        $user = User::create([
            'email' => 'admin@orbeaduanas.com',
            'password' => bcrypt('admin'),
            'state' => 'Activo'
        ]);




        $user->assignRole($role);


        $document = PersonalDocument::create([
            'name' => 'DNI',
            'number_digits' => 8,
            'state' => 'Activo'
        ]);


        CustomerSupplierDocument::create([
            'name' => 'RUC',
            'number_digits' => 11,
            'state' => 'Activo'
        ]);


        Personal::create([
            'id' => '99',
            'document_number' => '73184116',
            'names' => 'Bryan David',
            'last_name' => 'Estrada',
            'mother_last_name' => 'Gomez',
            'cellphone' => '977834697',
            'email' => 'admin@orbeaduanas.com',
            'address' => 'Av Revolucion Calle Q - Villa el Salvador',
            'img_url' =>  null,
            'state' => 'Activo',
            'sexo' => 'Masculino',
            'civil_status' => 'Soltero',
            'id_document' => $document->id,
            'id_user' => $user->id
        ]);

        /* Tipo de contenedor */

        $typeContainer = TypeContainer::create(['name' => 'DRY CONTAINER', 'description' => 'CONTENEDOR DE CARGA GENERAL']);

        /* Contenedor */
        Container::create([
            'name' => "20'ST",
            'type_container_id' => $typeContainer->id,
            'description' => '20 PIES STANDARD',
            'length' => 20,
            'width' => 20,
            'height' => 20,
            'max_load' => 20,
        ]);

        Container::create([
            'name' => "40'HQ",
            'type_container_id' => $typeContainer->id,
            'description' => '40 PIES STANDARD',
            'length' => 40,
            'width' => 40,
            'height' => 40,
            'max_load' => 2000,
        ]);

        /*  Regime */

        Regime::create(['code' => '10', 'description' => 'IMPORTACION']);
        Regime::create(['code' => '20', 'description' => 'IMPORTACION TEMPORAL']);
        Regime::create(['code' => '21', 'description' => 'ADMISION TEMPORAL']);
        Regime::create(['code' => '30', 'description' => 'REIMPORTACION']);
        Regime::create(['code' => '40', 'description' => 'EXPORTACION']);
        Regime::create(['code' => '70', 'description' => 'DEPOSITO']);
        Regime::create(['code' => '80', 'description' => 'TRANSITO']);
        Regime::create(['code' => '89', 'description' => 'REEMBARQUE']);

        /*  type_shipment */

        TypeShipment::create(['code' => '046', 'name' => 'Paita', 'description' => 'Marítima']);
        TypeShipment::create(['code' => '028', 'name' => 'Talara', 'description' => 'Marítima']);
        TypeShipment::create(['code' => '082', 'name' => 'Salaverry', 'description' => 'Marítima']);
        TypeShipment::create(['code' => '091', 'name' => 'Chimbote', 'description' => 'Marítima']);
        TypeShipment::create(['code' => '127', 'name' => 'Pisco', 'description' => 'Marítima']);
        TypeShipment::create(['code' => '163', 'name' => 'Ilo', 'description' => 'Marítima']);
        TypeShipment::create(['code' => '145', 'name' => 'Mollendo', 'description' => 'Marítima']);
        TypeShipment::create(['code' => '118', 'name' => 'Marítima del Callao', 'description' => 'Marítima']);
        TypeShipment::create(['code' => '019', 'name' => 'Tumbes', 'description' => 'Marítima']);
        TypeShipment::create(['code' => '055', 'name' => 'IAT Lambayeque', 'description' => 'Marítima']);
        TypeShipment::create(['code' => '154', 'name' => 'Arequipa', 'description' => 'Terrestre']);
        TypeShipment::create(['code' => '172', 'name' => 'Tacna', 'description' => 'Terrestre']);
        TypeShipment::create(['code' => '262', 'name' => 'Desaguadero', 'description' => 'Terrestre']);
        TypeShipment::create(['code' => '280', 'name' => 'Puerto Maldonado', 'description' => 'Terrestre']);
        TypeShipment::create(['code' => '299', 'name' => 'La Tina', 'description' => 'Terrestre']);
        TypeShipment::create(['code' => '181', 'name' => 'Puno', 'description' => 'Terrestre']);
        TypeShipment::create(['code' => '271', 'name' => 'Tarapoto', 'description' => 'Terrestre']);
        TypeShipment::create(['code' => '226', 'name' => 'Iquitos', 'description' => 'Fluvial']);
        TypeShipment::create(['code' => '217', 'name' => 'Pucallpa', 'description' => 'Fluvial']);
        TypeShipment::create(['code' => '190', 'name' => 'Cusco', 'description' => 'Fluvial']);
        TypeShipment::create(['code' => '235', 'name' => 'Aerea del Callao', 'description' => 'Aérea']);
        TypeShipment::create(['code' => '244', 'name' => 'Postal', 'description' => 'Aérea']);


        /* Type load */

        TypeLoad::create(['name' => 'Carga general', 'description' => 'Carga general', 'state' => 'Activo']);
        TypeLoad::create(['name' => 'Carga a granel', 'description' => 'Carga a granel', 'state' => 'Activo']);
        TypeLoad::create(['name' => 'Carga peligrosa', 'description' => 'Carga peligrosa', 'state' => 'Activo']);
        TypeLoad::create(['name' => 'Carga perecedera', 'description' => 'Carga perecedera', 'state' => 'Activo']);
        TypeLoad::create(['name' => 'Carga fragil', 'description' => 'Carga fragil', 'state' => 'Activo']);

        /* Packagin Type */

        PackingType::create(['name' => 'Pallets']);
        PackingType::create(['name' => 'Cajas']);

        /*  incoterms */
        Incoterms::create(['code' => 'EXW', 'name' => 'Ex Works', 'state' => 'Activo']);
        Incoterms::create(['code' => 'FCA', 'name' => 'Free Carrier', 'state' => 'Activo']);
        Incoterms::create(['code' => 'CPT', 'name' => 'Carriage Paid To', 'state' => 'Activo']);
        Incoterms::create(['code' => 'CIP', 'name' => 'Carriage and Insurance Paid To', 'state' => 'Activo']);
        Incoterms::create(['code' => 'DAP', 'name' => 'Delivered At Place', 'state' => 'Activo']);
        Incoterms::create(['code' => 'DPU', 'name' => 'Delivered at Place Unloaded', 'state' => 'Activo']);
        Incoterms::create(['code' => 'DDP', 'name' => 'Delivered Duty Paid', 'state' => 'Activo']);
        Incoterms::create(['code' => 'FAS', 'name' => 'Free Alongside Ship', 'state' => 'Activo']);
        Incoterms::create(['code' => 'FOB', 'name' => 'Free On Board', 'state' => 'Activo']);
        Incoterms::create(['code' => 'CFR', 'name' => 'Cost and Freight', 'state' => 'Activo']);
        Incoterms::create(['code' => 'CIF', 'name' => 'Cost, Insurance and Freight', 'state' => 'Activo']);

        /*  modality */
        Modality::create(['name' => 'ANTICIPADO']);
        Modality::create(['name' => 'DIFERIDO']);

        /* Type_Service */

        TypeService::create(['name' => 'Flete']);
        TypeService::create(['name' => 'Aduanas']);
        TypeService::create(['name' => 'Transporte']);

        /* TypeInsurance */
        $insuranceA = TypeInsurance::create(['name' => 'Seguro A', 'state' => 'Activo']);
        $insuranceB = TypeInsurance::create(['name' => 'Seguro B', 'state' => 'Activo']);

        /* Rate Insurance */
        InsuranceRates::create(['insurance_type_id' => $insuranceA->id, 'shipment_type_description' => 'Marítima', 'min_value' => 30000, 'fixed_cost' => 65, 'percentage' => 0.65]);
        InsuranceRates::create(['insurance_type_id' => $insuranceA->id, 'shipment_type_description' => 'Aérea', 'min_value' => 30000, 'fixed_cost' => 55, 'percentage' => 0.55]);
        InsuranceRates::create(['insurance_type_id' => $insuranceB->id, 'shipment_type_description' => 'Marítima', 'min_value' => 30000, 'fixed_cost' => 45, 'percentage' => 0.25]);
        InsuranceRates::create(['insurance_type_id' => $insuranceB->id, 'shipment_type_description' => 'Aérea', 'min_value' => 30000, 'fixed_cost' => 45, 'percentage' => 0.25]);


        /* Currencies */

        Currency::create(['badge' => 'Dólar estadounidense', 'abbreviation' => 'USD', 'symbol' => '$']);
        Currency::create(['badge' => 'Sol Peruano', 'abbreviation' => 'PEN', 'symbol' => 'S/']);
        Currency::create(['badge' => 'Libra Esterlina', 'abbreviation' => 'GBP', 'symbol' => '£']);
        Currency::create(['badge' => 'Euro', 'abbreviation' => 'EUR', 'symbol' => '€']);

        Commission::create(['name' => 'PRICING', 'default_amount' => '10', 'description' => 'COMISION DE PRICING POR CARGA CERRADA']);
        Commission::create(['name' => 'OPERACIONES', 'default_amount' => '10', 'description' => 'COMISION DE OPERACIONES POR CARGA CERRADA']);
        Commission::create(['name' => 'GASTOS ADMINISTRATIVOS', 'default_amount' => '10', 'description' => 'COMISION DE ADMINISTRACION POR CARGA CERRADA']);

        /* Navieras y Aerolineas */

        ShippingCompany::create(['name' => 'HAPAG LLOYD', 'contact' => 'Vania de la puente', 'cellphone' => '970032310', 'email' => 'AnaMaria.Coronado@hlag.com']);
        ShippingCompany::create(['name' => 'EVERGREEN', 'contact' => 'Ricardo Loayza', 'cellphone' => '', 'email' => 'rloayza@evergreen-shipping.com.pe']);


        Airline::create(['name' => 'LATAM', 'contact' => 'Midory Lucero', 'cellphone' => '980083287', 'email' => 'midofy.gonzales@latam.com']);
        Airline::create(['name' => 'AIRMAX CARGO', 'contact' => 'Nelly Sanchez', 'cellphone' => '998118980', 'email' => 'comercial@airmaxcargo.com.pe']);


        Supplier::create(['name_businessname' => 'HENAN XINGSHENGDA', 'address' => 'North section of renmin road, changge city', 'contact_name' => 'Asten Zho', 'contact_number' => '944653246', 'contact_email' => 'asten@hnidel.com', 'state' => 'Activo']);
        Supplier::create(['name_businessname' => 'Transporte Jefferson', 'address' => 'Elmer Faucett 474', 'contact_name' => 'Jefferson Maravi', 'contact_number' => '944653246', 'contact_email' => 'jeffeson@hnidel.com', 'area_type' => 'transporte', 'state' => 'Activo']);
        Supplier::create(['name_businessname' => 'MSL', 'address' => 'Av la Mar 45652', 'contact_name' => 'Lucho Cornejo', 'contact_number' => '944653346', 'contact_email' => 'lucho.cornejo@gmail.com', 'area_type' => 'pricing', 'state' => 'Activo']);


        Supplier::create([
            'name_businessname' => 'CHARTER S.A.C',
            'address' => 'Av. Prolongación 123, Lima',
            'contact_name' => 'Ricardo Torres',
            'contact_number' => '933223344',
            'contact_email' => 'proveedor1@orbeaduanas.com',
            'area_type' => 'pricing',
            'state' => 'Activo'
        ]);

        Supplier::create([
            'name_businessname' => 'Proveedor 2 S.A.C.',
            'address' => 'Calle Libertad 789, Lima',
            'contact_name' => 'Lucía Gómez',
            'contact_number' => '944556677',
            'contact_email' => 'proveedor2@orbeaduanas.com',
            'area_type' => 'pricing',
            'state' => 'Activo'
        ]);

        Supplier::create([
            'name_businessname' => 'Proveedor 3 S.A.C.',
            'address' => 'Av. 28 de Julio 456, Lima',
            'contact_name' => 'Juan Pérez',
            'contact_number' => '922334455',
            'contact_email' => 'proveedor3@orbeaduanas.com',
            'area_type' => 'pricing',
            'state' => 'Activo'
        ]);

        Supplier::create([
            'name_businessname' => 'Proveedor 4 S.A.C.',
            'address' => 'Calle El Sol 111, Lima',
            'contact_name' => 'María Rodríguez',
            'contact_number' => '988776655',
            'contact_email' => 'proveedor4@orbeaduanas.com',
            'area_type' => 'transporte',
            'state' => 'Activo'
        ]);

        Supplier::create([
            'name_businessname' => 'Proveedor 5 S.A.C.',
            'address' => 'Calle 24 de Mayo 333, Lima',
            'contact_name' => 'Carlos Díaz',
            'contact_number' => '966543210',
            'contact_email' => 'proveedor5@orbeaduanas.com',
            'area_type' => 'transporte',
            'state' => 'Activo'
        ]);

        Customer::create(['document_number' => '20550590710', 'name_businessname' => 'Orbe Aduanas S.A.C', 'address' => 'Av Elmer faucett 474', 'contact_name' => 'Jhon Cordova', 'contact_number' => '977834697', 'contact_email' => 'jhon.cordova@orbeaduanas.com', 'state' => 'Activo', 'id_document' => 1, 'id_personal' => 99, 'type' => 'cliente']);




        $this->call(CountrySeeder::class);
        $this->call(StatesCountrySeeder::class);
        $this->call(AddConcepts::class);
    }
}
