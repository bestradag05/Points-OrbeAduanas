<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\PersonalController;
use App\Http\Controllers\Api\RolesController as ApiRolesController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CargoController as ApiCargosController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\ContratModalitieController;
use App\Http\Controllers\Api\MoneyController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(
    [

        // 'middleware' => 'auth:api',
        'prefix' => 'auth',
        // 'middleware' => ['role:admin','permission:publish articles'],
    ],
    function ($router) {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('/me', [AuthController::class, 'me'])->name('me');
        Route::post('/list', [AuthController::class, 'list']);
        Route::post('/reg', [AuthController::class, 'reg']);
    }
);


Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    Route::resource("roles", ApiRolesController::class);
    Route::resource("documents", DocumentController::class);
    Route::post("personals/{id}",[PersonalController::class,"update"]);
    Route::get("personals/users", [PersonalController::class, "getPersonalWithUser"]);
    Route::resource("personals", PersonalController::class);

    Route::resource("users", UserController::class);

    Route::resource("cargos", ApiCargosController::class);

    Route::get("contracts/document/{id}", [ContractController::class, "getDocumentContract"]);
    Route::post("contracts/confirm/{id}", [ContractController::class, "confirmContract"]);
    Route::resource("contracts", ContractController::class);

    Route::post("contract_modalities/{id}",[ContratModalitieController::class,"update"]);
    Route::resource("contract_modalities", ContratModalitieController::class);

    Route::resource("companys", CompanyController::class);
    Route::post("companys/{id}", [CompanyController::class,"update"]);
    Route::resource("moneys", MoneyController::class);
    Route::resource("services", ServiceController::class);
});

