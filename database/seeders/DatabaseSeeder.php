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

        Permission::create(['name' => 'commercial.transport.accept.or.reject', 'alias' => 'Aceptar o Rechazar respuesta de cotizacion', 'guard_name' => 'web']);
        Permission::create(['name' => 'commercial.transport.close', 'alias' => 'Cerrar Cotizaciones', 'guard_name' => 'web']);
        Permission::create(['name' => 'commercial.transport.edit', 'alias' => 'Editar Valor Agregado de Transporte', 'guard_name' => 'web']);
        Permission::create(['name' => 'commercial.client.accept.or.reject', 'alias' => 'Aceptar o Rechazar cotizacion comercial', 'guard_name' => 'web']);
        Permission::create(['name' => 'commercial.quote.list', 'alias' => 'Todas las cotizaciones', 'guard_name' => 'web']);
        Permission::create(['name' => 'commercial.quote.list.personal', 'alias' => 'Cotizacion por personal', 'guard_name' => 'web']);

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
        $roleTransport = Role::create(['guard_name' => 'web', 'name' => 'Transporte']);
        $roleComercial = Role::create(['guard_name' => 'web', 'name' => 'Comercial']);
        $rolePricing = Role::create(['guard_name' => 'web', 'name' => 'Pricing']);



        $user = User::create([
            'email' => 'admin@orbeaduanas.com',
            'password' => bcrypt('admin'),
            'state' => 'Activo'
        ]);

/*         $userPricing = User::create([
            'email' => 'victor.gomez@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $userTransport = User::create([
            'email' => 'transporte@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $userCommercial = User::create([
            'email' => 'jorge.laura@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]); */

/*         $user1 = User::create([
            'email' => 'user1@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $user2 = User::create([
            'email' => 'user2@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $user3 = User::create([
            'email' => 'user3@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $user4 = User::create([
            'email' => 'user4@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $user5 = User::create([
            'email' => 'user5@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $user6 = User::create([
            'email' => 'user6@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $user7 = User::create([
            'email' => 'user7@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $user8 = User::create([
            'email' => 'user8@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $user9 = User::create([
            'email' => 'user9@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]);

        $user10 = User::create([
            'email' => 'user10@orbeaduanas.com',
            'password' => bcrypt('Orbe2025'),
            'state' => 'Activo'
        ]); */


/*         $user->assignRole($role);
        $userTransport->assignRole($roleTransport);
        $userCommercial->assignRole($roleComercial);
        $userPricing->assignRole($rolePricing); */



        $transportPermissions = [
            'supplier.module',
            'supplier.create',
            'supplier.update',
            'supplier.delete',
            'supplier.list',
            'customer.list',
            'transporte.module',
            'transporte.list.points',
            'transporte.generate',
            'transporte.list',
            'transporte.quote.list',
            'transporte.quote.list.personal',
            'transporte.quote.generate',
            'transporte.quote.response',
        ];

        // Crear permisos si no existen
        foreach ($transportPermissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm],
                ['alias' => ucwords(str_replace('.', ' ', $perm)), 'guard_name' => 'web']
            );
        }

        // Asignar permisos al rol Transporte
        $roleTransport = Role::where('name', 'Transporte')->first();
        if ($roleTransport) {
            $roleTransport->givePermissionTo($transportPermissions);
        }



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

        /* Personal::create([
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

        Personal::create([
            'id' => '101',
            'document_number' => '41478898',
            'names' => 'Jefferson',
            'last_name' => 'Maravi',
            'mother_last_name' => '',
            'cellphone' => '945868543',
            'email' => 'transporte@orbeaduanas.com',
            'address' => 'Av Revolucion Calle Q - Villa el Salvador',
            'img_url' =>  null,
            'state' => 'Activo',
            'sexo' => 'Masculino',
            'civil_status' => 'Soltero',
            'id_document' => $document->id,
            'id_user' => $userTransport->id
        ]);
 */

/*         Personal::create([
            'id' => '102',
            'document_number' => '79854269',
            'names' => 'Jorge',
            'last_name' => 'Laura',
            'mother_last_name' => '',
            'cellphone' => '942772672',
            'email' => 'jorge.laura@orbeaduanas.com',
            'address' => 'Av Revolucion Calle Q - Villa el Salvador',
            'img_url' =>  null,
            'state' => 'Activo',
            'sexo' => 'Masculino',
            'civil_status' => 'Soltero',
            'id_document' => $document->id,
            'id_user' => $userCommercial->id
        ]); */


       /*  $personal1 = Personal::create([
            'id' => '103',
            'document_number' => '12345678',
            'names' => 'Carlos',
            'last_name' => 'Perez',
            'mother_last_name' => 'Lopez',
            'cellphone' => '998877665',
            'email' => 'user1@orbeaduanas.com',
            'address' => 'Calle Ficticia 123',
            'img_url' => null,
            'state' => 'Activo',
            'sexo' => 'Masculino',
            'civil_status' => 'Soltero',
            'id_document' => $document->id,
            'id_user' => $user1->id
        ]);

        $personal2 = Personal::create([
            'id' => '104',
            'document_number' => '87654321',
            'names' => 'Ana',
            'last_name' => 'Martinez',
            'mother_last_name' => 'Gonzalez',
            'cellphone' => '977665544',
            'email' => 'user2@orbeaduanas.com',
            'address' => 'Calle Ficticia 456',
            'img_url' => null,
            'state' => 'Activo',
            'sexo' => 'Femenino',
            'civil_status' => 'Casada',
            'id_document' => $document->id,
            'id_user' => $user2->id
        ]);

        $personal3 = Personal::create([
            'id' => '105',
            'document_number' => '23456789',
            'names' => 'Luis',
            'last_name' => 'Gutierrez',
            'mother_last_name' => 'Ramos',
            'cellphone' => '922334455',
            'email' => 'user3@orbeaduanas.com',
            'address' => 'Calle Ficticia 789',
            'img_url' => null,
            'state' => 'Activo',
            'sexo' => 'Masculino',
            'civil_status' => 'Soltero',
            'id_document' => $document->id,
            'id_user' => $user3->id
        ]);

        $personal4 = Personal::create([
            'id' => '106',
            'document_number' => '34567890',
            'names' => 'Maria',
            'last_name' => 'Fernandez',
            'mother_last_name' => 'Hernandez',
            'cellphone' => '911223344',
            'email' => 'user4@orbeaduanas.com',
            'address' => 'Calle Ficticia 101',
            'img_url' => null,
            'state' => 'Activo',
            'sexo' => 'Femenino',
            'civil_status' => 'Soltera',
            'id_document' => $document->id,
            'id_user' => $user4->id
        ]);

        $personal5 = Personal::create([
            'id' => '107',
            'document_number' => '45678901',
            'names' => 'Ricardo',
            'last_name' => 'Ramirez',
            'mother_last_name' => 'Diaz',
            'cellphone' => '924556677',
            'email' => 'user5@orbeaduanas.com',
            'address' => 'Calle Ficticia 202',
            'img_url' => null,
            'state' => 'Activo',
            'sexo' => 'Masculino',
            'civil_status' => 'Divorciado',
            'id_document' => $document->id,
            'id_user' => $user5->id
        ]);

        $personal6 = Personal::create([
            'id' => '108',
            'document_number' => '56789012',
            'names' => 'Paula',
            'last_name' => 'Sanchez',
            'mother_last_name' => 'Morales',
            'cellphone' => '933667788',
            'email' => 'user6@orbeaduanas.com',
            'address' => 'Calle Ficticia 303',
            'img_url' => null,
            'state' => 'Activo',
            'sexo' => 'Femenino',
            'civil_status' => 'Casada',
            'id_document' => $document->id,
            'id_user' => $user6->id
        ]);

        $personal7 = Personal::create([
            'id' => '109',
            'document_number' => '67890123',
            'names' => 'Juan',
            'last_name' => 'Lopez',
            'mother_last_name' => 'Paredes',
            'cellphone' => '944778899',
            'email' => 'user7@orbeaduanas.com',
            'address' => 'Calle Ficticia 404',
            'img_url' => null,
            'state' => 'Activo',
            'sexo' => 'Masculino',
            'civil_status' => 'Soltero',
            'id_document' => $document->id,
            'id_user' => $user7->id
        ]);

        $personal8 = Personal::create([
            'id' => '110',
            'document_number' => '78901234',
            'names' => 'Pedro',
            'last_name' => 'Vasquez',
            'mother_last_name' => 'Gonzales',
            'cellphone' => '955889900',
            'email' => 'user8@orbeaduanas.com',
            'address' => 'Calle Ficticia 505',
            'img_url' => null,
            'state' => 'Activo',
            'sexo' => 'Masculino',
            'civil_status' => 'Casado',
            'id_document' => $document->id,
            'id_user' => $user8->id
        ]);

        $personal9 = Personal::create([
            'id' => '111',
            'document_number' => '89012345',
            'names' => 'Marta',
            'last_name' => 'Diaz',
            'mother_last_name' => 'Loza',
            'cellphone' => '911334455',
            'email' => 'user9@orbeaduanas.com',
            'address' => 'Calle Ficticia 606',
            'img_url' => null,
            'state' => 'Activo',
            'sexo' => 'Femenino',
            'civil_status' => 'Soltera',
            'id_document' => $document->id,
            'id_user' => $user9->id
        ]);

        $personal10 = Personal::create([
            'id' => '112',
            'document_number' => '90123456',
            'names' => 'Carlos',
            'last_name' => 'Gomez',
            'mother_last_name' => 'Lozano',
            'cellphone' => '922112233',
            'email' => 'user10@orbeaduanas.com',
            'address' => 'Calle Ficticia 707',
            'img_url' => null,
            'state' => 'Activo',
            'sexo' => 'Masculino',
            'civil_status' => 'Soltero',
            'id_document' => $document->id,
            'id_user' => $user10->id
        ]); */



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
        $insuranceA = TypeInsurance::create(['name' => 'Seguro A', 'state' => 'Activo']);
        $insuranceB = TypeInsurance::create(['name' => 'Seguro B', 'state' => 'Activo']);

        /* Rate Insurance */
        InsuranceRates::create(['insurance_type_id' => $insuranceA->id, 'shipment_type_description' => 'Marítima', 'min_value' => 30000, 'fixed_cost' => 65, 'percentage' => 0.65]);
        InsuranceRates::create(['insurance_type_id' => $insuranceA->id, 'shipment_type_description' => 'Aérea', 'min_value' => 30000, 'fixed_cost' => 55, 'percentage' => 0.55]);
        InsuranceRates::create(['insurance_type_id' => $insuranceB->id, 'shipment_type_description' => 'Marítima', 'min_value' => 30000, 'fixed_cost' => 45, 'percentage' => 0.25]);
        InsuranceRates::create(['insurance_type_id' => $insuranceB->id, 'shipment_type_description' => 'Aérea', 'min_value' => 30000, 'fixed_cost' => 45, 'percentage' => 0.25]);

        $this->call(CountrySeeder::class);
        $this->call(StatesCountrySeeder::class);

        /* Navieras y Aerolineas */

        ShippingCompany::create(['name' => 'HAPAG LLOYD', 'contact' => 'Vania de la puente', 'cellphone' => '970032310', 'email' => 'AnaMaria.Coronado@hlag.com']);
        ShippingCompany::create(['name' => 'EVERGREEN', 'contact' => 'Ricardo Loayza', 'cellphone' => '', 'email' => 'rloayza@evergreen-shipping.com.pe']);


        Airline::create(['name' => 'LATAM', 'contact' => 'Midory Lucero', 'cellphone' => '980083287', 'email' => 'midofy.gonzales@latam.com']);
        Airline::create(['name' => 'AIRMAX CARGO', 'contact' => 'Nelly Sanchez', 'cellphone' => '998118980', 'email' => 'comercial@airmaxcargo.com.pe']);



        /* Proceso para el routing */
        /* $customer = Customer::create(['document_number' => '20550590710', 'name_businessname' => 'Orbe Aduanas S.A.C', 'address' => 'Av Elmer faucett 474', 'contact_name' => 'Jhon Cordova', 'contact_number' => '977834697', 'contact_email' => 'jhon.cordova@orbeaduanas.com', 'state' => 'Activo', 'id_document' => $customer_supplier_document->id, 'id_personal' => $personal->id]);
        $customer1 = Customer::create([
            'document_number' => '20550590711',
            'name_businessname' => 'Cliente 1 S.A.C.',
            'address' => 'Calle Ficticia 123, Lima',
            'contact_name' => 'Carlos Mendoza',
            'contact_number' => '988877665',
            'contact_email' => 'cliente1@orbeaduanas.com',
            'state' => 'Activo',
            'id_document' => $customer_supplier_document->id,
            'id_personal' => $personal1->id
        ]);

        $customer2 = Customer::create([
            'document_number' => '20550590712',
            'name_businessname' => 'Cliente 2 S.A.C.',
            'address' => 'Calle Ficticia 456, Lima',
            'contact_name' => 'Ana Vargas',
            'contact_number' => '966543210',
            'contact_email' => 'cliente2@orbeaduanas.com',
            'state' => 'Activo',
            'id_document' => $customer_supplier_document->id,
            'id_personal' => $personal2->id
        ]);

        $customer3 = Customer::create([
            'document_number' => '20550590713',
            'name_businessname' => 'Cliente 3 S.A.C.',
            'address' => 'Calle Ficticia 789, Lima',
            'contact_name' => 'Luis Fernandez',
            'contact_number' => '944556677',
            'contact_email' => 'cliente3@orbeaduanas.com',
            'state' => 'Activo',
            'id_document' => $customer_supplier_document->id,
            'id_personal' => $personal3->id
        ]);

        $customer4 = Customer::create([
            'document_number' => '20550590714',
            'name_businessname' => 'Cliente 4 S.A.C.',
            'address' => 'Calle Ficticia 101, Lima',
            'contact_name' => 'Maria López',
            'contact_number' => '933223344',
            'contact_email' => 'cliente4@orbeaduanas.com',
            'state' => 'Activo',
            'id_document' => $customer_supplier_document->id,
            'id_personal' => $personal4->id
        ]);

        $customer5 = Customer::create([
            'document_number' => '20550590715',
            'name_businessname' => 'Cliente 5 S.A.C.',
            'address' => 'Calle Ficticia 202, Lima',
            'contact_name' => 'Ricardo Torres',
            'contact_number' => '922334455',
            'contact_email' => 'cliente5@orbeaduanas.com',
            'state' => 'Activo',
            'id_document' => $customer_supplier_document->id,
            'id_personal' => $personal5->id
        ]); */



        Supplier::create(['name_businessname' => 'HENAN XINGSHENGDA', 'address' => 'North section of renmin road, changge city', 'contact_name' => 'Asten Zho', 'contact_number' => '944653246', 'contact_email' => 'asten@hnidel.com', 'state' => 'Activo']);
        Supplier::create(['name_businessname' => 'Transporte Jefferson', 'address' => 'Elmer Faucett 474', 'contact_name' => 'Jefferson Maravi', 'contact_number' => '944653246', 'contact_email' => 'jeffeson@hnidel.com', 'area_type' => 'transporte', 'state' => 'Activo']);
        Supplier::create(['name_businessname' => 'MSL', 'address' => 'Av la Mar 45652', 'contact_name' => 'Lucho Cornejo', 'contact_number' => '944653346', 'contact_email' => 'lucho.cornejo@gmail.com', 'area_type' => 'pricing', 'state' => 'Activo']);


        $supplier1 = Supplier::create([
            'name_businessname' => 'CHARTER S.A.C',
            'address' => 'Av. Prolongación 123, Lima',
            'contact_name' => 'Ricardo Torres',
            'contact_number' => '933223344',
            'contact_email' => 'proveedor1@orbeaduanas.com',
            'area_type' => 'pricing',
            'state' => 'Activo'
        ]);

        $supplier2 = Supplier::create([
            'name_businessname' => 'Proveedor 2 S.A.C.',
            'address' => 'Calle Libertad 789, Lima',
            'contact_name' => 'Lucía Gómez',
            'contact_number' => '944556677',
            'contact_email' => 'proveedor2@orbeaduanas.com',
            'area_type' => 'pricing',
            'state' => 'Activo'
        ]);

        $supplier3 = Supplier::create([
            'name_businessname' => 'Proveedor 3 S.A.C.',
            'address' => 'Av. 28 de Julio 456, Lima',
            'contact_name' => 'Juan Pérez',
            'contact_number' => '922334455',
            'contact_email' => 'proveedor3@orbeaduanas.com',
            'area_type' => 'pricing',
            'state' => 'Activo'
        ]);

        $supplier4 = Supplier::create([
            'name_businessname' => 'Proveedor 4 S.A.C.',
            'address' => 'Calle El Sol 111, Lima',
            'contact_name' => 'María Rodríguez',
            'contact_number' => '988776655',
            'contact_email' => 'proveedor4@orbeaduanas.com',
            'area_type' => 'transporte',
            'state' => 'Activo'
        ]);

        $supplier5 = Supplier::create([
            'name_businessname' => 'Proveedor 5 S.A.C.',
            'address' => 'Calle 24 de Mayo 333, Lima',
            'contact_name' => 'Carlos Díaz',
            'contact_number' => '966543210',
            'contact_email' => 'proveedor5@orbeaduanas.com',
            'area_type' => 'transporte',
            'state' => 'Activo'
        ]);



        /* Commissions */

        Commission::create(['name' => 'PRICING', 'default_amount' => '10', 'description' => 'COMISION DE PRICING POR CARGA CERRADA']);
        Commission::create(['name' => 'OPERACIONES', 'default_amount' => '10', 'description' => 'COMISION DE OPERACIONES POR CARGA CERRADA']);
        Commission::create(['name' => 'GASTOS ADMINISTRATIVOS', 'default_amount' => '10', 'description' => 'COMISION DE ADMINISTRACION POR CARGA CERRADA']);

        /* Currencies */

        Currency::create(['badge' => 'Dólar estadounidense', 'abbreviation' => 'USD', 'symbol' => '$']);
        Currency::create(['badge' => 'Sol Peruano', 'abbreviation' => 'PEN', 'symbol' => 'S/']);
        Currency::create(['badge' => 'Libra Esterlina', 'abbreviation' => 'GBP', 'symbol' => '£']);
        Currency::create(['badge' => 'Euro', 'abbreviation' => 'EUR', 'symbol' => '€']);

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





        /* Commercial Quote */

        /* $quote1 = CommercialQuote::create([
            'nro_quote_commercial' => 'TCOST001',
            'origin' => 1, 
            'destination' => 2, 
            'customer_company_name' => 'Cliente 1 S.A.C.',
            'load_value' => 5000.00,
            'id_personal' => $personal1->id,
            'id_type_shipment' => 8, 
            'id_regime' => 1, 
            'id_incoterms' => 1, 
            'id_type_load' => 1, 
            'id_customer' => $customer1->id,
            'id_supplier' => $supplier1->id,
            'lcl_fcl' => 'LCL',
            'is_consolidated' => false,
            'commodity' => 'Electrónicos',
            'nro_package' => '10',
            'id_packaging_type' => 1, 
            'kilograms' => 1000.00,
            'volumen' => 20.00,
            'pounds' => 2204.62,
            'kilogram_volumen' => 50.00,
            'tons' => 1.00,
            'measures' => '',
            'cif_value' => null,
            'valid_until' => now()->addDays(5),
            'state' => 'Pendiente'
        ]);

        $quote2 = CommercialQuote::create([
            'nro_quote_commercial' => 'TCOST002',
            'origin' => 3, 
            'destination' => 4, 
            'customer_company_name' => 'Cliente 2 S.A.C.',
            'load_value' => 7000.00,
            'id_personal' => $personal2->id,
            'id_type_shipment' => 21, 
            'id_regime' => 2, 
            'id_incoterms' => 2, 
            'id_type_load' => 2, 
            'id_customer' => $customer2->id,
            'id_supplier' => $supplier2->id,
            'lcl_fcl' => 'FCL',
            'is_consolidated' => false,
            'commodity' => 'Muebles',
            'nro_package' => '15',
            'id_packaging_type' => 2, 
            'kilograms' => 1500.00,
            'volumen' => 30.00,
            'pounds' => 3306.93,
            'kilogram_volumen' => 60.00,
            'tons' => 1.50,
            'measures' => '',
            'cif_value' => null,
            'valid_until' => now()->addDays(5),
            'state' => 'Pendiente'
        ]);

        $quote3 = CommercialQuote::create([
            'nro_quote_commercial' => 'TCOST003',
            'origin' => 5,
            'destination' => 6,
            'customer_company_name' => 'Cliente 3 S.A.C.',
            'load_value' => 6000.00,
            'id_personal' => $personal3->id,
            'id_type_shipment' => 21,
            'id_regime' => 3,
            'id_incoterms' => 3,
            'id_type_load' => 3,
            'id_customer' => $customer3->id,
            'id_supplier' => $supplier3->id,
            'lcl_fcl' => 'LCL',
            'is_consolidated' => false,
            'commodity' => 'Cereales',
            'nro_package' => '12',
            'id_packaging_type' => 1,
            'kilograms' => 2000.00,
            'volumen' => 40.00,
            'pounds' => 4409.24,
            'kilogram_volumen' => 80.00,
            'tons' => 2.00,
            'measures' => '',
            'cif_value' => null,
            'valid_until' => now()->addDays(5),
            'state' => 'Pendiente'
        ]);

        $quote4 = CommercialQuote::create([
            'nro_quote_commercial' => 'TCOST004',
            'origin' => 7,
            'destination' => 8,
            'customer_company_name' => 'Cliente 4 S.A.C.',
            'load_value' => 8000.00,
            'id_personal' => $personal4->id,
            'id_type_shipment' => 8,
            'id_regime' => 4,
            'id_incoterms' => 4,
            'id_type_load' => 4,
            'id_customer' => $customer4->id,
            'id_supplier' => $supplier4->id,
            'lcl_fcl' => 'FCL',
            'is_consolidated' => false,
            'commodity' => 'Maquinaria',
            'nro_package' => '5',
            'id_packaging_type' => 2,
            'kilograms' => 2500.00,
            'volumen' => 50.00,
            'pounds' => 5511.56,
            'kilogram_volumen' => 100.00,
            'tons' => 2.50,
            'measures' => '',
            'cif_value' => null,
            'valid_until' => now()->addDays(5),
            'state' => 'Pendiente'
        ]);

        $quote5 = CommercialQuote::create([
            'nro_quote_commercial' => 'TCOST005',
            'origin' => 9,
            'destination' => 10,
            'customer_company_name' => 'Cliente 5 S.A.C.',
            'load_value' => 9000.00,
            'id_personal' => $personal5->id,
            'id_type_shipment' => 8,
            'id_regime' => 5,
            'id_incoterms' => 5,
            'id_type_load' => 5,
            'id_customer' => $customer5->id,
            'id_supplier' => $supplier5->id,
            'lcl_fcl' => 'LCL',
            'is_consolidated' => false,
            'commodity' => 'Ropa',
            'nro_package' => '20',
            'id_packaging_type' => 1,
            'kilograms' => 1000.00,
            'volumen' => 10.00,
            'pounds' => 2204.62,
            'kilogram_volumen' => 10.00,
            'tons' => 1.00,
            'measures' => '',
            'cif_value' => null,
            'valid_until' => now()->addDays(5),
            'state' => 'Pendiente'
        ]); */
    }
}
