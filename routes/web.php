<?php

use App\Events\QuoteNotification;
use App\Http\Controllers\AdditionalPointsController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\CommercialQuoteController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\ConceptsController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateCountryController;
use App\Http\Controllers\CustomerSupplierDocumentController;
use App\Http\Controllers\FreightController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncotermsController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\MessageQuoteFreightController;
use App\Http\Controllers\MessageQuoteTransportController;
use App\Http\Controllers\ModalityController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PersonalDocumentController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\QuoteFreightController;
use App\Http\Controllers\QuoteTransportController;
use App\Http\Controllers\RegimeController;
use App\Http\Controllers\ResponseTransportQuoteController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\TypeInsuranceController;
use App\Http\Controllers\TypeLoadController;
use App\Http\Controllers\TypeShipmentController;
use App\Http\Controllers\UserController;
use App\Models\MessageQuoteTransport;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PackingTypeController;
use App\Http\Controllers\ResponseFreightQuotesController;
use App\Http\Controllers\ShippingCompanyController;
use App\Http\Controllers\TypeContainerController;
use App\Models\CommercialQuote;
use App\Models\ResponseFreightQuotes;
use App\Models\ResponseTransportQuote;
use App\Models\ShippingCompany;
use Barryvdh\DomPDF\Facade\Pdf;

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

Route::get('/routingpdf/{id}', function ($id) {

    $commercialQuote = CommercialQuote::findOrFail($id);
    $freight = $commercialQuote->freight;
    $concepts = $freight->concepts;

    $pdf = Pdf::loadView('freight.pdf.routingOrder', compact('commercialQuote', 'concepts', 'freight'));

    return $pdf->stream('Routing Order.pdf');
});

Route::get('/', function () {
    return view('auth/login');
});


Route::get('/link', function () {
    Artisan::call('storage:link');
});

/* Route::get('/alert', function () {
    $userId = auth()->user()->id;  // O cualquier otro ID de usuario al que le quieras enviar la notificación

    // Emitir el evento pasando el mensaje y el ID del usuario
    broadcast(new QuoteNotification("Tienes una cotización nueva por responder"));
}); */

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::resource('users', UserController::class);
    Route::resource('personal', PersonalController::class);
    Route::resource('personal_document', PersonalDocumentController::class);
    Route::resource('customer_supplier_document', CustomerSupplierDocumentController::class);
    Route::resource('roles', RolesController::class);
    Route::get('roles/grupos/{id}', [RolesController::class, 'templateRoles']);
    Route::post('roles/grupos/{idRol}', [RolesController::class, 'addPersonGroup']);
    Route::delete('roles/grupos/{id}', [RolesController::class, 'deletePersonGroup']);
    Route::resource('permissions', PermissionsController::class);
    Route::get('roles/grupos/permissions/{id}', [PermissionsController::class, 'templatePermissions']);
    Route::get('roles/grupos/assignpermission/{id_permission}/{id_role}', [PermissionsController::class, 'assingPermission']);
    Route::get('roles/grupos/removepermission/{id_permission}/{id_role}', [PermissionsController::class, 'removePermission']);

    Route::get('roles/grupos/add-all-permissions/{id_role}/{modulo}', [PermissionsController::class, 'addAllPermissions']);
    Route::get('roles/grupos/remove-all-permissions/{id_role}/{modulo}', [PermissionsController::class, 'removeAllPermissions']);

    Route::resource('concepts', ConceptsController::class);
    Route::get('/api/consult-ruc/{ruc}', [CustomerController::class, 'consultRuc']);
    Route::get('/customer/data/{document_number}', [CustomerController::class, 'getDataForRuc']);
    Route::resource('customer', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('type_shipment', TypeShipmentController::class);
    Route::resource('type_load', TypeLoadController::class);
    Route::resource('type_insurance', TypeInsuranceController::class);
    Route::resource('incoterms', IncotermsController::class);
    Route::resource('modality', ModalityController::class);

    Route::resource('routing', RoutingController::class);
    Route::get('routing/{id_routing}/detail', [RoutingController::class, 'getTemplateDetailRouting'])->name('routing.detail');
    Route::get('routing/{id_routing}/documents', [RoutingController::class, 'getTemplateDocumentsRouting']);
    Route::post('routing_service', [RoutingController::class, 'storeRoutingService']);
    Route::post('routing_insurance', [RoutingController::class, 'storeInsuranceService']);
    /* Route::get('getLCLFCL', [RoutingController::class, 'getLCLFCL']); */

    Route::get('custom/pending', [CustomController::class, 'getCustomPending']);
    Route::resource('custom', CustomController::class);
    /* Route::post('custom/load', [CustomController::class, 'loadDocument']); */

    /* Paises */
    Route::resource('country', CountryController::class);

    /* Ciudades */
    Route::resource('state_country', StateCountryController::class);

    /* Regimenes */

    Route::resource('regimes', RegimeController::class);

    /* Comisiones */
    Route::resource('commissions', CommissionController::class);

    /* Currencies */
    Route::resource('currencies', CurrencyController::class);

    Route::resource('containers', ContainerController::class);
    Route::resource('type_containers', TypeContainerController::class);

    Route::get('freight/pending', [FreightController::class, 'getFreightPending']);
    Route::get('freight/personal', [FreightController::class, 'getFreightPersonal']);
    Route::get('freight/{id}/point', [FreightController::class, 'getTemplateGeneratePointFreight']);
    Route::patch('freight/{id}/point', [FreightController::class, 'updatePointFreight']);
    Route::resource('freight', FreightController::class);
    Route::get('freight/create/{quoteId}', [FreightController::class, 'createFreight']);
    Route::post('freight/routing/', [FreightController::class, 'generateRouting']);
    Route::post('freight/upload_file/{id}', [FreightController::class, 'uploadFreightFiles']);
    Route::delete('freight/delete_file/{id}', [FreightController::class, 'deleteFreightFiles']);
    Route::put('freight/send-operation/{id}', [FreightController::class, 'sendToOperation']);
    Route::post('freight/notify', [FreightController::class, 'notifyCommercial']);



    Route::resource('customs', CustomController::class);

    Route::get('transport/pending', [TransportController::class, 'getTransportPending']);
    Route::get('transport/personal', [TransportController::class, 'getTransportPersonal']);
    Route::resource('transport', TransportController::class);
    Route::get('transport/create/{quoteId}', [TransportController::class, 'createTransport']);

    //TODO: Modificar la ruta, ya que la respuesta debe ir en el controlador de ResponseTransportQuoteController
    //TODO: Seguir las reglas de Api RESTful 
    Route::post(
        'transport/quote/{id}/prices',
        [QuoteTransportController::class, 'storeConceptPrices']
    )
        ->name('transport.quote.storePrices');


    /* Respuestas cotizaciones de flete */

    Route::post(
        'freight/quote/{quote}/responses',
        [ResponseFreightQuotesController::class, 'store']
    )->name('freight.quote.responses.store');

    Route::prefix('quote/freight/response')->group(function() {
    Route::get('{response}/show', [ResponseFreightQuotesController::class, 'show'])->name('quote.freight.response.show');
    Route::post('{response}/accept', [ResponseFreightQuotesController::class, 'accept'])->name('quote.freight.response.accept');
    Route::post('{response}/reject', [ResponseFreightQuotesController::class, 'reject'])->name('quote.freight.response.reject');
    Route::get('{response}/generate', [ResponseFreightQuotesController::class, 'generate'])->name('quote.freight.response.generate');
});

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
    Route::get('quote/transport/personal', [QuoteTransportController::class, 'getQuoteTransportPersonal']);
    Route::patch('quote/transport/complete/{id}', [QuoteTransportController::class, 'updateQuoteTransport']);
    Route::post('quote/transport/file-upload-documents', [QuoteTransportController::class, 'uploadFilesQuoteTransport']);
    Route::post('quote/transport/file-delete-documents', [QuoteTransportController::class, 'deleteFilesQuoteTransport']);

    Route::resource('quote/transport', QuoteTransportController::class)->names([
        'create' => 'quote.transport.create',
        'store' => 'quote.transport.store',
    ]);

    Route::post('transport/quote/{id}/responses', [ResponseTransportQuoteController::class, 'store'])
        ->name('transport.quote.responses.store');

    // Aceptar respuesta como aprobada por el cliente
    Route::post('transport/quote/accept', [QuoteTransportController::class, 'acceptResponse'])
        ->name('transport.quote.accept');

    // Rechazar una respuesta (en cualquier estado)
    Route::post('transport/quote/reject', [QuoteTransportController::class, 'rejectResponse'])
        ->name('transport.quote.reject');





    /* Mensaje de cotizaciones de flete */

    Route::resource('quote/transport/message', MessageQuoteTransportController::class);

    Route::get('quote/search-routing/{nro_operation}', [QuoteTransportController::class, 'searchRouting']);
    Route::patch('quote/transport/cost/{id}', [QuoteTransportController::class, 'costTransport']);
    Route::delete('quote/transport/{id}/{action}', [QuoteTransportController::class, 'updateStateQuoteTransport']);
    /*    Route::patch('quote/transport/cost/{action}/{id}', [QuoteTransportController::class, 'handleTransportAction']); */
    Route::get('quote/transport/cost/reject/{id}', [QuoteTransportController::class, 'rejectQuoteTransport']);
    Route::get('quote/transport/cost/keep/{id}', [QuoteTransportController::class, 'keepQuoteTransport']);
    Route::patch('quote/transport/cost/accept/{id}', [QuoteTransportController::class, 'acceptQuoteTransport']);
    Route::get('quote/transport/cost/corrected/{id}', [QuoteTransportController::class, 'correctedQuoteTransport']);

    /* Cotizaciones de flete */

    Route::resource('quote/freight', QuoteFreightController::class)->names('quote.freight');
    //TODO:Esta ruta ya no se usara
    /*  Route::patch('quote/freight/cost/accept/{id}', [QuoteFreightController::class, 'acceptQuoteFreight']); */
    /* Route::delete('quote/freight/{id}/{action}', [QuoteFreightController::class, 'updateStateQuoteFreight']); */

    Route::post('quote/freight/file-upload-documents', [QuoteFreightController::class, 'uploadFilesQuoteFreight']);
    Route::post('quote/freight/file-delete-documents', [QuoteFreightController::class, 'deleteFilesQuoteFreight']);
    Route::get('quote/freight/sendQuote/{id}', [QuoteFreightController::class, 'sendQuote']);

    Route::patch('quote/freight/send-pricing/{id}', [QuoteFreightController::class, 'sendInfoAndNotifyPricing']);


    /* Cotizaciones comerciales */

    Route::get('commercial/quote/{id_quote}/detail', [CommercialQuoteController::class, 'getTemplateDetailCommercialQuote'])->name('commercial.quote.detail');
    Route::get('commercial/quote/{id_quote}/quotes', [CommercialQuoteController::class, 'getTemplateQuoteCommercialQuote']);
    Route::get('commercial/quote/{id_quote}/documents', [CommercialQuoteController::class, 'getTemplateDocmentCommercialQuote']);
    Route::post('commercial/quote/completeData', [CommercialQuoteController::class, 'completeData']);

    Route::get('commercial/createQuote/{nro_quote_commercial}', [CommercialQuoteController::class, 'createQuote']);
    Route::get('commercial/quote/getPDF/{id}', [CommercialQuoteController::class, 'getPDF']);
    Route::get('commercial/service/{service}/{id}', [CommercialQuoteController::class, 'editCommercialQuoteService']);
    Route::get('commercial/quote/state/{action}/{id}', [CommercialQuoteController::class, 'handleActionCommercialQuote']);
    Route::patch('commercial/quote/updatedate/{id}', [CommercialQuoteController::class, 'updateDate']);
    Route::get('commercial/customer/{name}', [CommercialQuoteController::class, 'showCustomerForName']);
    Route::resource('commercial/quote', CommercialQuoteController::class);

    Route::post('commercial/quote/client-trace', [CommercialQuoteController::class, 'storeClientTrace'])
        ->name('commercial.quote.clientTrace');


    /* Packing type */

    Route::resource('packing_type', PackingTypeController::class);

    /* Airlines */

    Route::resource('airline', AirlineController::class);

    /* Navieras */

    Route::resource('shipping_company', ShippingCompanyController::class);

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
