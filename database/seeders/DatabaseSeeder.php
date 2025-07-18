<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Airline;
use App\Models\Commission;
use App\Models\Concept;
use App\Models\Container;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerSupplierDocument;
use App\Models\Incoterms;
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



        Permission::create(['name' => 'users.create', 'alias' => 'Crear usuarios', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.update', 'alias' => 'Actualizar usuarios', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.delete', 'alias' => 'Eliminar usuarios', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.list', 'alias' => 'Listar usuarios', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.createGroup', 'alias' => 'Crear Grupos', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.updateGroup', 'alias' => 'Actualizar Grupos', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.deleteGroup', 'alias' => 'Eliminar Grupos', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.listGroup', 'alias' => 'Listar Grupos', 'guard_name' => 'web']);


        Permission::create(['name' => 'personal.create', 'alias' => 'Crear personal', 'guard_name' => 'web']);
        Permission::create(['name' => 'personal.update', 'alias' => 'Actualizar personal', 'guard_name' => 'web']);
        Permission::create(['name' => 'personal.delete', 'alias' => 'Eliminar personal', 'guard_name' => 'web']);
        Permission::create(['name' => 'personal.list', 'alias' => 'Listar personal', 'guard_name' => 'web']);

        Permission::create(['name' => 'incoterms.create', 'alias' => 'Crear incoterm', 'guard_name' => 'web']);
        Permission::create(['name' => 'incoterms.update', 'alias' => 'Actualizar incoterm', 'guard_name' => 'web']);
        Permission::create(['name' => 'incoterms.delete', 'alias' => 'Eliminar incoterm', 'guard_name' => 'web']);
        Permission::create(['name' => 'incoterms.list', 'alias' => 'Listar incoterm', 'guard_name' => 'web']);

        Permission::create(['name' => 'liquidacion.list', 'alias' => 'Listar puntos', 'guard_name' => 'web']);
        Permission::create(['name' => 'liquidacion.generate', 'alias' => 'Generar puntos', 'guard_name' => 'web']);


        Permission::create(['name' => 'operaciones.list', 'alias' => 'Listar puntos', 'guard_name' => 'web']);
        Permission::create(['name' => 'operaciones.generate', 'alias' => 'Generar puntos', 'guard_name' => 'web']);
        Permission::create(['name' => 'operaciones.type_insurance', 'alias' => 'Tipo de Seguro', 'guard_name' => 'web']);


        Permission::create(['name' => 'transporte.module', 'alias' => 'Modulo de transporte', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.list.points', 'alias' => 'Listar puntos', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.generate', 'alias' => 'Generar puntos', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.list', 'alias' => 'Listar Transportes', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.quote.list', 'alias' => 'Todas las cotizaciones', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.quote.list.personal', 'alias' => 'Cotizacion por personal', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.quote.generate', 'alias' => 'Generar Cotizaciones', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.quote.response', 'alias' => 'Responder Cotizaciones', 'guard_name' => 'web']);




        Permission::create(['name' => 'additional.list', 'alias' => 'Listar Adicionales', 'guard_name' => 'web']);
        Permission::create(['name' => 'additional.listAll', 'alias' => 'Listar todos los adicionales', 'guard_name' => 'web']);
        Permission::create(['name' => 'additional.custom', 'alias' => 'Adicional de Aduanas', 'guard_name' => 'web']);
        Permission::create(['name' => 'additional.freight', 'alias' => 'Adicional de Flete', 'guard_name' => 'web']);
        Permission::create(['name' => 'additional.generate', 'alias' => 'Generar puntos', 'guard_name' => 'web']);



        Permission::create(['name' => 'points.module', 'alias' => 'Modulo de Puntos', 'guard_name' => 'web']);


        Permission::create(['name' => 'customer.create', 'alias' => 'Crear Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.update', 'alias' => 'Actualizar Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.delete', 'alias' => 'Eliminar Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.list', 'alias' => 'Listar Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.all', 'alias' => 'Listar todos los clientes', 'guard_name' => 'web']);

        Permission::create(['name' => 'supplier.module', 'alias' => 'Visualizar Modulo', 'guard_name' => 'web']);
        Permission::create(['name' => 'supplier.create', 'alias' => 'Crear Proveedor', 'guard_name' => 'web']);
        Permission::create(['name' => 'supplier.update', 'alias' => 'Actualizar Proveedor', 'guard_name' => 'web']);
        Permission::create(['name' => 'supplier.delete', 'alias' => 'Eliminar Proveedor', 'guard_name' => 'web']);
        Permission::create(['name' => 'supplier.list', 'alias' => 'Listar Proveedor', 'guard_name' => 'web']);

        Permission::create(['name' => 'type_shipment.create', 'alias' => 'Crear Tipo de embarque', 'guard_name' => 'web']);
        Permission::create(['name' => 'type_shipment.update', 'alias' => 'Actualizar Tipo de embarque', 'guard_name' => 'web']);
        Permission::create(['name' => 'type_shipment.delete', 'alias' => 'Eliminar Tipo de embarque', 'guard_name' => 'web']);
        Permission::create(['name' => 'type_shipment.list', 'alias' => 'Listar Tipo de embarque', 'guard_name' => 'web']);

        Permission::create(['name' => 'modality.create', 'alias' => 'Crear modalidad', 'guard_name' => 'web']);
        Permission::create(['name' => 'modality.update', 'alias' => 'Actualizar modalidad', 'guard_name' => 'web']);
        Permission::create(['name' => 'modality.delete', 'alias' => 'Eliminar modalidad', 'guard_name' => 'web']);
        Permission::create(['name' => 'modality.list', 'alias' => 'Listar modalidad', 'guard_name' => 'web']);

        Permission::create(['name' => 'routing.create', 'alias' => 'Crear Routing', 'guard_name' => 'web']);
        Permission::create(['name' => 'routing.update', 'alias' => 'Actualizar Routing', 'guard_name' => 'web']);
        Permission::create(['name' => 'routing.delete', 'alias' => 'Eliminar Routing', 'guard_name' => 'web']);
        Permission::create(['name' => 'routing.list', 'alias' => 'Listar Routing', 'guard_name' => 'web']);


        Permission::create(['name' => 'concept.create', 'alias' => 'Crear concepto', 'guard_name' => 'web']);
        Permission::create(['name' => 'concept.update', 'alias' => 'Actualizar concepto', 'guard_name' => 'web']);
        Permission::create(['name' => 'concept.delete', 'alias' => 'Eliminar concepto', 'guard_name' => 'web']);
        Permission::create(['name' => 'concept.list', 'alias' => 'Listar concepto', 'guard_name' => 'web']);

        //Crear un rol de Super-Admin
        $role = Role::create(['guard_name' => 'web', 'name' => 'Super-Admin']);


        $user = User::create([
            'email' => 'admin@orbeaduanas.com',
            'password' => bcrypt('admin'),
            'state' => 'Activo'
        ]);

        $userPricing = User::create([
            'email' => 'victor.gomez@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $user->assignRole($role);


        $document = PersonalDocument::create([
            'name' => 'DNI',
            'number_digits' => 8,
            'state' => 'Activo'
        ]);


        $customer_supplier_document = CustomerSupplierDocument::create([
            'name' => 'RUC',
            'number_digits' => 11,
            'state' => 'Activo'
        ]);


        $personal = Personal::create([
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

        Personal::create([
            'id' => '100',
            'document_number' => '796521448',
            'names' => 'Victor',
            'last_name' => 'Gomez',
            'mother_last_name' => 'Canelo',
            'cellphone' => '966523658',
            'email' => 'victor.gomez@orbeaduanas.com',
            'address' => 'Av Revolucion Calle Q - Villa el Salvador',
            'img_url' =>  null,
            'state' => 'Activo',
            'sexo' => 'Masculino',
            'civil_status' => 'Soltero',
            'id_document' => $document->id,
            'id_user' => $userPricing->id
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

        TypeService::create(['name' => 'Aduanas']);
        TypeService::create(['name' => 'Flete']);
        TypeService::create(['name' => 'Transporte']);

        /* TypeInsurance */
        TypeInsurance::create(['name' => 'Seguro A', 'state' => 'Activo']);
        TypeInsurance::create(['name' => 'Seguro B', 'state' => 'Activo']);

        $this->call(CountrySeeder::class);
        $this->call(StatesCountrySeeder::class);

        /* Navieras y Aerolineas */

        ShippingCompany::create(['name' => 'HAPAG LLOYD', 'contact' => 'Vania de la puente', 'cellphone' => '970032310', 'email' => 'AnaMaria.Coronado@hlag.com']);
        ShippingCompany::create(['name' => 'EVERGREEN', 'contact' => 'Ricardo Loayza', 'cellphone' => '', 'email' => 'rloayza@evergreen-shipping.com.pe']);
    

        Airline::create(['name' => 'LATAM', 'contact' => 'Midory Lucero', 'cellphone' => '980083287', 'email' => 'midofy.gonzales@latam.com']);
        Airline::create(['name' => 'AIRMAX CARGO', 'contact' => 'Nelly Sanchez', 'cellphone' => '998118980', 'email' => 'comercial@airmaxcargo.com.pe']);



        /* Proceso para el routing */
        $customer = Customer::create(['document_number' => '20550590710', 'name_businessname' => 'Orbe Aduanas S.A.C', 'address' => 'Av Elmer faucett 474', 'contact_name' => 'Jhon Cordova', 'contact_number' => '977834697', 'contact_email' => 'jhon.cordova@orbeaduanas.com', 'state' => 'Activo', 'id_document' => $customer_supplier_document->id, 'id_personal' => $personal->id]);
        Supplier::create(['name_businessname' => 'HENAN XINGSHENGDA', 'address' => 'North section of renmin road, changge city', 'contact_name' => 'Asten Zho', 'contact_number' => '944653246', 'contact_email' => 'asten@hnidel.com', 'state' => 'Activo']);
        Supplier::create(['name_businessname' => 'Transporte Jefferson', 'address' => 'Elmer Faucett 474', 'contact_name' => 'Jefferson Maravi', 'contact_number' => '944653246', 'contact_email' => 'jeffeson@hnidel.com', 'area_type' => 'transporte', 'state' => 'Activo']);
        Supplier::create(['name_businessname' => 'MSL', 'address' => 'Av la Mar 45652', 'contact_name' => 'Lucho Cornejo', 'contact_number' => '944653346', 'contact_email' => 'lucho.cornejo@gmail.com', 'area_type' => 'pricing', 'state' => 'Activo']);


        /* Commissions */

        Commission::create(['name' => 'PRICING', 'default_amount' => '10', 'description' => 'COMISION DE PRICING POR CARGA CERRADA']);
        Commission::create(['name' => 'OPERACIONES', 'default_amount' => '10', 'description' => 'COMISION DE OPERACIONES POR CARGA CERRADA']);
        Commission::create(['name' => 'GASTOS ADMINISTRATIVOS', 'default_amount' => '10', 'description' => 'COMISION DE ADMINISTRACION POR CARGA CERRADA']);

        /* Currencies */

        Currency::create(['badge' => 'Dólar estadounidense', 'abbreviation' => 'USD', 'symbol' => '$']);
        Currency::create(['badge' => 'Sol Peruano', 'abbreviation' => 'PEN', 'symbol' => 'S/']);
        Currency::create(['badge' => 'Libra Esterlina','abbreviation' => 'GBP','symbol' => '£']);
        Currency::create(['badge' => 'Euro','abbreviation' => 'EUR','symbol' => '€']);

        Routing::create(['nro_operation' => 'ORBE-24254', 'origin' => 'PERU - CALLAO', 'destination' => 'CHINA - SHANGAI', 'load_value' => '2700', 'id_personal' => $personal->id, 'id_customer' => $customer->id, 'id_type_shipment' => 8, 'lcl_fcl' => 'LCL', 'packaging_type' => 'Pallets', 'id_type_load' => 1, 'id_regime' => 1, 'id_incoterms' => 1, 'id_supplier' => 1, 'commodity' => 'CILINDRO']);
        Routing::create(['nro_operation' => 'ORBE-25255', 'origin' => 'China - Shanghai', 'destination' => 'Perú - Callao', 'wr_loading' => null, 'load_value' => 2600.00, 'id_personal' => 99, 'id_customer' => 1, 'id_type_shipment' => 8, 'id_regime' => 1, 'id_incoterms' => 1, 'id_supplier' => 1, 'id_type_load' => 1, 'lcl_fcl' => 'LCL', 'commodity' => 'TELESCOPIC ROD', 'nro_package' => '2', 'packaging_type' => 'CAJAS', 'container_type' => null, 'pounds' => 4209.61, 'kilograms' => 1904.80, 'volumen' => 8.37, 'kilogram_volumen' => null, 'tons' => null, 'measures' => '{"1":{"amount":2,"width":"233.00","length":"433.00","height":"533.00"}}', 'hs_code' => null, 'observation' => null, 'state' => 'Activo', 'created_at' => '2025-01-06 22:30:54', 'updated_at' => '2025-01-06 22:30:54']);
        Routing::create(['nro_operation' => 'ORBE-25256', 'origin' => 'Bielorrusia - Brestskaya obl.', 'destination' => 'Perú - Callao', 'wr_loading' => null, 'load_value' => 6500.00, 'id_personal' => 99, 'id_customer' => 1, 'id_type_shipment' => 8, 'id_regime' => 1, 'id_incoterms' => 1, 'id_supplier' => 1, 'id_type_load' => 1, 'lcl_fcl' => 'FCL', 'commodity' => 'CILINDRO', 'nro_package' => '1', 'packaging_type' => 'PALLET', 'container_type' => '1x20ST', 'pounds' => null, 'kilograms' => null, 'volumen' => 2100.00, 'kilogram_volumen' => null, 'tons' => 21.00, 'measures' => '{"1":{"amount":1,"width":"233.00","length":"433.00","height":"324.00"}}', 'hs_code' => null, 'observation' => null, 'state' => 'Activo', 'created_at' => '2025-01-07 01:26:28', 'updated_at' => '2025-01-07 01:26:28']);
        Routing::create(['nro_operation' => 'ORBE-25257', 'origin' => 'Chile - Atacama', 'destination' => 'Perú - Callao', 'wr_loading' => null, 'load_value' => 780.00, 'id_personal' => 99, 'id_customer' => 1, 'id_type_shipment' => 21, 'id_regime' => 1, 'id_incoterms' => 9, 'id_supplier' => 1, 'id_type_load' => 1, 'lcl_fcl' => null, 'commodity' => 'LLANTAS', 'nro_package' => '1', 'packaging_type' => 'CAJAS', 'container_type' => null, 'pounds' => 5158.14, 'kilograms' => 2334.00, 'volumen' => null, 'kilogram_volumen' => 233.00, 'tons' => null, 'measures' => '{"1":{"amount":1,"width":"433.00","length":"233.00","height":"433.00"}}', 'hs_code' => null, 'observation' => null, 'state' => 'Activo', 'created_at' => '2025-01-07 01:27:48', 'updated_at' => '2025-01-07 01:27:48']);

        Concept::create(['name' => 'AGENCIAMIENTO DE ADUANAS', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'AGENCIAMIENTO DE ADUANAS', 'id_type_shipment' => 21, 'id_type_service' => 1]);
        Concept::create(['name' => 'COMISION DE ADUANA', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'GASTOS OPERATIVOS', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'GASTOS ADMINISTRATIVOS', 'id_type_shipment' => 21, 'id_type_service' => 1]);
        Concept::create(['name' => 'HAWB', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'INLAND GROUND', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concept::create(['name' => 'DELIVERY AIRPO', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concept::create(['name' => 'AIR FREIGHT', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concept::create(['name' => 'F.S.C', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'OCEAN FREIGHT', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'CUADRILLA', 'id_type_shipment' => 8, 'id_type_service' => 3]);
        Concept::create(['name' => 'CUADRILLA', 'id_type_shipment' => 21, 'id_type_service' => 3]);
        Concept::create(['name' => 'RESGUARDO', 'id_type_shipment' => 8, 'id_type_service' => 3]);
        Concept::create(['name' => 'SEGURO', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concept::create(['name' => 'SEGURO', 'id_type_shipment' => 21, 'id_type_service' => 1]);
        Concept::create(['name' => 'SEGURO', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concept::create(['name' => 'TRANSPORTE', 'id_type_shipment' => 21, 'id_type_service' => 3]);
        Concept::create(['name' => 'TRANSPORTE', 'id_type_shipment' => 8, 'id_type_service' => 3]);
    }
}
