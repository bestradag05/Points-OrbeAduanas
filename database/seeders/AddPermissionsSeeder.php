<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
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


        Permission::create(['name' => 'customerProviders.module', 'alias' => 'Modulo de clientes y proveedores', 'guard_name' => 'web']);
        
        Permission::create(['name' => 'customer.create', 'alias' => 'Crear Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.update', 'alias' => 'Actualizar Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.delete', 'alias' => 'Eliminar Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.list', 'alias' => 'Listar Clientes', 'guard_name' => 'web']);
        Permission::create(['name' => 'customer.all', 'alias' => 'Listar todos los clientes', 'guard_name' => 'web']);

        
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

        Permission::create(['name' => 'commercialQuote.module', 'alias' => 'Modulo de cotización comercial', 'guard_name' => 'web']);
        Permission::create(['name' => 'commercialQuote.generate', 'alias' => 'Generar cotización comercial', 'guard_name' => 'web']);
        Permission::create(['name' => 'commercialQuote.list', 'alias' => 'Listar cotizaciónes comerciales', 'guard_name' => 'web']);
        Permission::create(['name' => 'commercialQuote.listSentClient', 'alias' => 'Listar cotizaciones enviadas al cliente', 'guard_name' => 'web']);

        Permission::create(['name' => 'concept.create', 'alias' => 'Crear concepto', 'guard_name' => 'web']);
        Permission::create(['name' => 'concept.update', 'alias' => 'Actualizar concepto', 'guard_name' => 'web']);
        Permission::create(['name' => 'concept.delete', 'alias' => 'Eliminar concepto', 'guard_name' => 'web']);
        Permission::create(['name' => 'concept.list', 'alias' => 'Listar concepto', 'guard_name' => 'web']);

        Permission::create(['name' => 'freight.module', 'alias' => 'Modulo de Flete', 'guard_name' => 'web']);
        Permission::create(['name' => 'freight.quote_freight', 'alias' => 'Lista de cotizaciones', 'guard_name' => 'web']);
        Permission::create(['name' => 'freight.list', 'alias' => 'Mis Fletes', 'guard_name' => 'web']);
        
        Permission::create(['name' => 'airlineShippingCompanies.module', 'alias' => 'Modulo de Aerolínea y Navieras', 'guard_name' => 'web']);
        Permission::create(['name' => 'airlineShippingCompanies.airline', 'alias' => 'Aerolíneas', 'guard_name' => 'web']);
        Permission::create(['name' => 'airlineShippingCompanies.shippingCompanies', 'alias' => 'Navieras', 'guard_name' => 'web']);

        Permission::create(['name' => 'commissions.module', 'alias' => 'Modulo de comisiones', 'guard_name' => 'web']);
        Permission::create(['name' => 'commissions.companyCommissions', 'alias' => 'Comisiones de la empresa', 'guard_name' => 'web']);
        Permission::create(['name' => 'commissions.sellerCommissions', 'alias' => 'Gestion de comisiones de vendedor', 'guard_name' => 'web']);

        Permission::create(['name' => 'container.module', 'alias' => 'Modulo de contenedores ', 'guard_name' => 'web']);
        Permission::create(['name' => 'container.list', 'alias' => 'Gestion de contenedores', 'guard_name' => 'web']);
        Permission::create(['name' => 'container.containerType', 'alias' => 'Gestion de tipo de contenedores', 'guard_name' => 'web']);

    }
}
