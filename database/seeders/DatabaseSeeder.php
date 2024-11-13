<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Concepts;
use App\Models\Customer;
use App\Models\Document;
use App\Models\Incoterms;
use App\Models\Modality;
use App\Models\Personal;
use App\Models\Regime;
use App\Models\Routing;
use App\Models\Shipper;
use App\Models\Supplier;
use App\Models\TypeInsurance;
use App\Models\TypeLoad;
use App\Models\TypeService;
use App\Models\TypeShipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
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

        Permission::create(['name' => 'liquidacion.list', 'alias' => 'Listar liquidacion', 'guard_name' => 'web']);
        Permission::create(['name' => 'liquidacion.generate', 'alias' => 'Generar puntos', 'guard_name' => 'web']);


        Permission::create(['name' => 'operaciones.list', 'alias' => 'Listar operaciones', 'guard_name' => 'web']);
        Permission::create(['name' => 'operaciones.generate', 'alias' => 'Generar puntos', 'guard_name' => 'web']);
       
        
        Permission::create(['name' => 'transporte.list', 'alias' => 'Listar transporte', 'guard_name' => 'web']);
        Permission::create(['name' => 'transporte.generate', 'alias' => 'Generar puntos', 'guard_name' => 'web']);
       
    

        Permission::create(['name' => 'additional.list', 'alias' => 'Listar Adicionales', 'guard_name' => 'web']);
        Permission::create(['name' => 'additional.custom', 'alias' => 'Adicional de Aduanas', 'guard_name' => 'web']);
        Permission::create(['name' => 'additional.freight', 'alias' => 'Adicional de Flete', 'guard_name' => 'web']);
        Permission::create(['name' => 'additional.generate', 'alias' => 'Generar puntos', 'guard_name' => 'web']);

        

        Permission::create(['name' => 'points.list', 'alias' => 'Listar Puntos', 'guard_name' => 'web']);
   

        Permission::create(['name' => 'customer.create', 'alias' => 'Crear Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.update', 'alias' => 'Actualizar Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.delete', 'alias' => 'Eliminar Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.list', 'alias' => 'Listar Clientes', 'guard_name' => 'web']);

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
         $role = Role::create(['guard_name' => 'web','name' => 'Super-Admin']);


        $user = User::create([
            'email' => 'admin@orbeaduanas.com',
            'password' => bcrypt('admin'),
            'state' => 'Activo'
        ]);

        $user->assignRole($role);

        $permissions = Permission::all();
    
        $role->givePermissionTo($permissions);
       


        $document = Document::create([
            'name' => 'DNI',
            'number_digits' => 8,
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
        TypeShipment::create(['code' => '118', 'name' => 'Maritima del Callao', 'description' => 'Marítima']);
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

        TypeLoad::create(['name' => 'Carga general', 'description' => 'Carga general']);
        TypeLoad::create(['name' => 'Carga a granel', 'description' => 'Carga a granel']);
        TypeLoad::create(['name' => 'Carga peligrosa', 'description' => 'Carga peligrosa']);
        TypeLoad::create(['name' => 'Carga perecedera', 'description' => 'Carga perecedera']);
        TypeLoad::create(['name' => 'Carga fragil', 'description' => 'Carga fragil']);

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
        Modality::create(['name' => 'DIFERIDO']);

        /* Type_Service */

        TypeService::create(['name' => 'Aduanas']);
        TypeService::create(['name' => 'Flete']);
        TypeService::create(['name' => 'Transporte']);

        /* TypeInsurance */

        
        TypeInsurance::create(['name' => 'Seguro A']);
        TypeInsurance::create(['name' => 'Seguro B']);
        
        $this->call(CountrySeeder::class);
        $this->call(StatesCountrySeeder::class);



        /* Proceso para el routing */
     /*    Customer::create(['ruc' => '20550590710', 'name_businessname' => 'Orbe Aduanas S.A.C', 'contact_name' => 'Jhon Cordova', 'contact_number' => '977834697', 'contact_email' => 'jhon.cordova@orbeaduanas.com', 'id_user' => 1]);
        Supplier::create(['type_id' => 'RUC', 'number_id' => '20554630740', 'name_businessname' => 'HENAN XINGSHENGDA', 'addres' => 'North section of renmin road, changge city', 'contact_name' => 'Asten Zho', 'contact_number' => '944653246', 'contact_email' => 'asten@hnidel.com', 'type_suppliers' => 'Venta']);
        Routing::create(['nro_operation' => 'ORBE-24254', 'origin' => 'PERU - CALLAO', 'destination' => 'CHINA - SHANGAI', 'freight_value' => '2500', 'load_value' => '2700', 'insurance_value' => '25', 'id_personal' => 1, 'id_customer' => 1, 'id_type_shipment' => 8, 'lcl_fcl' => 'LCL', 'id_type_load' => 1, 'id_regime' => 1, 'id_incoterms' => 1, 'id_supplier' => 1, 'commodity' => 'CILINDRO']);
 */

        Concepts::create(['name' => 'COMISION DE ADUANA', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concepts::create(['name' => 'GASTOS OPERATIVOS', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concepts::create(['name' => 'GASTOS ADMINISTRATIVOS', 'id_type_shipment' => 21, 'id_type_service' => 1]);
        Concepts::create(['name' => 'HAWB', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concepts::create(['name' => 'INLAND GROUND', 'id_type_shipment' => 8, 'id_type_service' => 1]);
        Concepts::create(['name' => 'DELIVERY AIRPO', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concepts::create(['name' => 'AIR FREIGHT', 'id_type_shipment' => 21, 'id_type_service' => 2]);
        Concepts::create(['name' => 'F.S.C', 'id_type_shipment' => 8, 'id_type_service' => 2]);
        Concepts::create(['name' => 'OCEAN FREIGHT', 'id_type_shipment' => 8, 'id_type_service' => 2]);
    }
}
