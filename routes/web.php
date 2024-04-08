<?php

use App\Http\Controllers\CustomController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\ModalityController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\TypeShipmentController;
use App\Http\Controllers\UserController;
use App\Models\Custom;
use App\Models\Modality;
use PhpParser\Node\Expr\List_;

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

    /*   Route::get('/users', function () {
        return view('users/list-users');
    })->name('users'); */

    Route::resource('users', UserController::class);
    Route::resource('personal', PersonalController::class);
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

    Route::resource('customer', CustomerController::class);
    Route::resource('type_shipment', TypeShipmentController::class);
    Route::resource('modality', ModalityController::class);
   
    Route::resource('routing', RoutingController::class);
    Route::get('routing/{id_routing}/detail', [RoutingController::class, 'getTemplateDetailRouting']);
    Route::post('routing_service', [RoutingController::class, 'storeRoutingService']);

    Route::get('custom/pendiente', [CustomController::class, 'getCustomPending']);
    Route::resource('custom', CustomController::class);
    Route::post('custom/load', [CustomController::class, 'loadDocument']);

    
});
