<?php

use App\Http\Controllers\AdditionalPointsController;
use App\Http\Controllers\ConceptsController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerSupplierDocumentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FreightController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncotermsController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\ModalityController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PersonalDocumentController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\QuoteTransportController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\TypeInsuranceController;
use App\Http\Controllers\TypeLoadController;
use App\Http\Controllers\TypeShipmentController;
use App\Http\Controllers\UserController;
use App\Models\Transport;
use App\Models\TypeInsurance;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');


    Route::resource('users', UserController::class);
    Route::resource('personal', PersonalController::class);
    Route::resource('personal_document', PersonalDocumentController::class);
    Route::resource('customer_supplier_document', CustomerSupplierDocumentController::class);
    Route::resource('roles', RolesController::class);
    Route::get('roles/grupos/{id}', [RolesController::class, 'templateRoles']);
    Route::post('roles/grupos/{rol}', [RolesController::class, 'addPersonGroup']);
    Route::delete('roles/grupos/{id}', [RolesController::class, 'deletePersonGroup']);
    Route::resource('permissions', PermissionsController::class);
    Route::get('roles/grupos/permissions/{id}', [PermissionsController::class, 'templatePermissions']);
    Route::get('roles/grupos/assignpermission/{id_permission}/{id_role}', [PermissionsController::class, 'assingPermission']);
    Route::get('roles/grupos/removepermission/{id_permission}/{id_role}', [PermissionsController::class, 'removePermission']);

    Route::get('roles/grupos/add-all-permissions/{id_role}/{modulo}', [PermissionsController::class, 'addAllPermissions']);
    Route::get('roles/grupos/remove-all-permissions/{id_role}/{modulo}', [PermissionsController::class, 'removeAllPermissions']);

    Route::resource('concepts', ConceptsController::class);
    Route::get('/obtener-datos-ruc/{ruc}', [CustomerController::class, 'obtenerDatosRuc']);
    Route::resource('customer', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('type_shipment', TypeShipmentController::class);
    Route::resource('type_load', TypeLoadController::class);
    Route::resource('type_insurance', TypeInsuranceController::class);
    Route::resource('incoterms', IncotermsController::class);
    Route::resource('modality', ModalityController::class);

    Route::resource('routing', RoutingController::class);
    Route::get('routing/{id_routing}/detail', [RoutingController::class, 'getTemplateDetailRouting']);
    Route::get('routing/{id_routing}/documents', [RoutingController::class, 'getTemplateDocumentsRouting']);
    Route::post('routing_service', [RoutingController::class, 'storeRoutingService']);
    Route::post('routing_insurance', [RoutingController::class, 'storeInsuranceService']);
    Route::get('getLCLFCL', [RoutingController::class, 'getLCLFCL']);

    Route::get('custom/pending', [CustomController::class, 'getCustomPending']);
    Route::resource('custom', CustomController::class);
    /* Route::post('custom/load', [CustomController::class, 'loadDocument']); */

    Route::get('freight/pending', [FreightController::class, 'getFreightPending']);
    Route::resource('freight', FreightController::class);

    Route::get('transport/pending', [TransportController::class, 'getTransportPending']);
    Route::resource('transport', TransportController::class);

    Route::get('insurance/pending', [InsuranceController::class, 'getInsurancePending']);
    Route::resource('insurance', InsuranceController::class);

    Route::get('additionals/pending/custom', [AdditionalPointsController::class, 'getAdditionalPendingCustom']);
    Route::get('additionals/pending/freight', [AdditionalPointsController::class, 'getAdditionalPendingFreight']);
    Route::resource('additionals', AdditionalPointsController::class);

    Route::get('points/detail', [PointsController::class, 'getPointDetail']);
    Route::get('points/customs', [PointsController::class, 'getPointCustoms']);
    Route::get('points/freight', [PointsController::class, 'getPointFreight']);
    Route::get('points/transport', [PointsController::class, 'getPointTransport']);
    Route::get('points/insurance', [PointsController::class, 'getPointInsurance']);
    Route::get('points/additionals', [PointsController::class, 'getPointAdditional']);

    /* Cotizaciones Transporte */

    Route::resource('quote/transport', QuoteTransportController::class)->names([
        'create' => 'quote.transport.create',
    ]);
    Route::get('quote/search-routing/{nro_operation}', [QuoteTransportController::class, 'searchRouting']);
    Route::patch('quote/transport/cost/{id}', [QuoteTransportController::class, 'costTransport']);


    /* Reportes */

    Route::get('points/export/customs/{type}', [PointsController::class, 'exportCustom']);
    Route::get('points/export/customs/{type}', [PointsController::class, 'exportCustom']);

    Route::get('points/export/freight/{type}', [PointsController::class, 'exportFreight']);
    Route::get('points/export/freight/{type}', [PointsController::class, 'exportFreight']);

    Route::get('points/export/transport/{type}', [PointsController::class, 'exportTransport']);
    Route::get('points/export/transport/{type}', [PointsController::class, 'exportTransport']);

    Route::get('points/export/insurance/{type}', [PointsController::class, 'exportInsurance']);
    Route::get('points/export/insurance/{type}', [PointsController::class, 'exportInsurance']);

    Route::get('points/export/additionals/{type}', [PointsController::class, 'exportAdditional']);
    Route::get('points/export/additionals/{type}', [PointsController::class, 'exportAdditional']);
});
