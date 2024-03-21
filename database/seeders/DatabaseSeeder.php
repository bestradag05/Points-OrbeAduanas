<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Incoterms;
use App\Models\Modality;
use App\Models\Personal;
use App\Models\Regime;
use App\Models\Routing;
use App\Models\Shipper;
use App\Models\TypeService;
use App\Models\TypeShipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'email' => 'admin@orbeaduanas.com',
            'password' => bcrypt('admin')
        ]);

        Personal::create([
            'name' => 'admin',
            'last_name' => 'administrador',
            'cellphone' => '966523654',
            'email' => 'admin@orbeaduanas.com',
            'dni' => '75214554',
            'img_url' => 'user_default.png',
            'id_user' => 1
        ]);
        
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

        Permission::create(['name' => 'liquidacion.create', 'alias' => 'Crear liquidacion', 'guard_name' => 'web']);
        Permission::create(['name' => 'liquidacion.update', 'alias' => 'Actualizar liquidacion', 'guard_name' => 'web']);
        Permission::create(['name' => 'liquidacion.delete', 'alias' => 'Eliminar liquidacion', 'guard_name' => 'web']);
        Permission::create(['name' => 'liquidacion.list', 'alias' => 'Listar liquidacion', 'guard_name' => 'web']);

        Permission::create(['name' => 'operaciones.create', 'alias' => 'Crear operaciones', 'guard_name' => 'web']);
        Permission::create(['name' => 'operaciones.update', 'alias' => 'Actualizar operaciones', 'guard_name' => 'web']);
        Permission::create(['name' => 'operaciones.delete', 'alias' => 'Eliminar operaciones', 'guard_name' => 'web']);
        Permission::create(['name' => 'operaciones.list', 'alias' => 'Listar operaciones', 'guard_name' => 'web']);

        Permission::create(['name' => 'transporte.create', 'alias' => 'Crear transporte', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.update', 'alias' => 'Actualizar transporte', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.delete', 'alias' => 'Eliminar transporte', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.list', 'alias' => 'Listar transporte', 'guard_name' => 'web']);

        Permission::create(['name' => 'admin.create', 'alias' => 'Crear admin', 'guard_name' => 'web']);
        Permission::create(['name' => 'admin.update', 'alias' => 'Actualizar admin', 'guard_name' => 'web']);
        Permission::create(['name' => 'admin.delete', 'alias' => 'Eliminar admin', 'guard_name' => 'web']);
        Permission::create(['name' => 'admin.list', 'alias' => 'Listar admin', 'guard_name' => 'web']);


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

        TypeShipment::create(['code' => '046', 'description' => 'Marítima - Paita']);
        TypeShipment::create(['code' => '028', 'description' => 'Marítima - Talara']);
        TypeShipment::create(['code' => '082', 'description' => 'Marítima - Salaverry']);
        TypeShipment::create(['code' => '091', 'description' => 'Marítima - Chimbote']);
        TypeShipment::create(['code' => '127', 'description' => 'Marítima - Pisco']);
        TypeShipment::create(['code' => '163', 'description' => 'Marítima - Ilo']);
        TypeShipment::create(['code' => '145', 'description' => 'Marítima - Mollendo']);
        TypeShipment::create(['code' => '118', 'description' => 'Marítima - Callao']);
        TypeShipment::create(['code' => '019', 'description' => 'Marítima - Tumbes']);
        TypeShipment::create(['code' => '055', 'description' => 'Marítima - IAT Lambayeque']);
        TypeShipment::create(['code' => '154', 'description' => 'Terrestre - Arequipa']);
        TypeShipment::create(['code' => '172', 'description' => 'Terrestre - Tacna']);
        TypeShipment::create(['code' => '262', 'description' => 'Terrestre - Desaguadero']);
        TypeShipment::create(['code' => '280', 'description' => 'Terrestre - Puerto Maldonado']);
        TypeShipment::create(['code' => '299', 'description' => 'Terrestre - La Tina']);
        TypeShipment::create(['code' => '181', 'description' => 'Terrestre - Puno']);
        TypeShipment::create(['code' => '271', 'description' => 'Terrestre - Tarapoto']);
        TypeShipment::create(['code' => '226', 'description' => 'Fluvial - Iquitos']);
        TypeShipment::create(['code' => '217', 'description' => 'Fluvial - Pucallpa']);
        TypeShipment::create(['code' => '190', 'description' => 'Fluvial - Cusco']);
        TypeShipment::create(['code' => '235', 'description' => 'Aérea - Callao']);
        TypeShipment::create(['code' => '244', 'description' => 'Aérea - Postal']);


        /*  incoterms */
        Incoterms::create(['code' => 'EXW', 'name' => 'Ex Works']);
        Incoterms::create(['code' => 'FCA', 'name' => 'Free Carrier']);
        Incoterms::create(['code' => 'CPT', 'name' => 'Carriage Paid To']);
        Incoterms::create(['code' => 'CIP', 'name' => 'Carriage and Insurance Paid To']);
        Incoterms::create(['code' => 'DAP', 'name' => 'Delivered At Place']);
        Incoterms::create(['code' => 'DPU', 'name' => 'Delivered at Place Unloaded']);
        Incoterms::create(['code' => 'DDP', 'name' => 'Delivered Duty Paid']);
        Incoterms::create(['code' => 'FAS', 'name' => 'Free Alongside Ship']);
        Incoterms::create(['code' => 'FOB', 'name' => 'Free On Board']);
        Incoterms::create(['code' => 'CFR', 'name' => 'Cost and Freight']);
        Incoterms::create(['code' => 'CIF', 'name' => 'Cost, Insurance and Freight']);

        /*  modality */
        Modality::create(['name' => 'ANTICIPADO']);
        Modality::create([ 'name' => 'DIFERIDO']);

        /* Type_Service */

        TypeService::create(['name'=> 'Aduanas']);
        TypeService::create(['name'=> 'Flete']);
        TypeService::create(['name'=> 'Seguro']);
        TypeService::create(['name'=> 'Transporte']);
        TypeService::create(['name'=> 'Adicionales']);



        $this->call(CountrySeeder::class);
        $this->call(StatesCountrySeeder::class);



          /* Proceso para el routing */
          User::create(['email' => 'liquidador@orbeaduanas.com', 'password' => bcrypt('password')]);
          Personal::create(['name' => 'Anderson', 'last_name' => 'moron', 'cellphone' => '977234697', 'email' => 'liquidador@orbeaduanas.com', 'dni' => '73184116', 'immigration_card' => '', 'passport' => '', 'img_url' => '73184116.png', 'id_user' => 2]);
          Customer::create(['ruc' => '20550590710', 'name_businessname' => 'Orbe Aduanas S.A.C', 'contact_name' => 'Jhon Cordova', 'contact_number' => '977834697', 'contact_email' => 'jhon.cordova@orbeaduanas.com', 'id_user' => 2]);
          Shipper::create(['type_id' => 'RUC', 'number_id' => '20554630740', 'name_businessname' => 'HENAN XINGSHENGDA', 'addres' => 'North section of renmin road, changge city', 'contact_name' => 'Asten Zho' , 'contact_number' => '944653246', 'contact_email' => 'asten@hnidel.com']);
          Routing::create(['nro_operation' => 'ORBE-24254', 'origin' => 'PERU - CALLAO', 'destination' => 'CHINA - SHANGAI', 'freight_value' => '2500', 'load_value' => '2700', 'insurance_value' => '25', 'id_personal' => 1, 'id_customer' => 1, 'id_type_shipment' => 1, 'id_modality' => 1, 'id_regime' => 1, 'id_incoterms' => 1, 'id_shipper' => 1, 'commodity' => 'CILINDRO']);
    }
}
