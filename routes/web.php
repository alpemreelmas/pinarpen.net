<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\servicesController;
use App\Http\Controllers\portfoliosController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CustomerPaymentController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\DebtPaymentController;
use App\Http\Controllers\ExpenditureController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/",[homeController::class,"index"]);

Route::get("/about",[homeController::class,"about"]);

Route::get("/contact",[homeController::class,"contact"]);

Route::get("/portfolios",[homeController::class,"portfolios"]);
Route::get("/portfolios/{slug}/{id}",[HomeController::class,"portfolios_detail"]);

Route::get("/services",[homeController::class,"services"]);

Route::get("/admin", [adminController::class,"checkPath"]);

Route::get("/admin/login",[adminController::class,"login"]);
Route::post("/admin/login",[adminController::class,"login_post"]);

Route::prefix('admin')->middleware(["is_admin"])->group(function () {

    Route::get('/dashboard', [adminController::class,"dashboard"]);

    Route::post("/logout",[adminController::class,"logout"]);

    Route::prefix('services')->group(function () {
        Route::get('/', [servicesController::class, 'index']);
        Route::get('/create', [servicesController::class, 'create']);
        Route::post("/",[servicesController::class, "store"]);
        Route::get("/{id}/edit",[servicesController::class, "edit"]);
        Route::put("/{id}",[servicesController::class, "update"]);
        Route::delete("/",[servicesController::class, "delete"]);
    });

    Route::prefix('portfolios')->group(function () {
        Route::get('/', [portfoliosController::class, 'index']);
        Route::get('/create', [portfoliosController::class, 'create']);
        Route::post("/",[portfoliosController::class, "store"]);
        Route::get("/{id}/edit",[portfoliosController::class, "edit"]);
        Route::put("/{id}",[portfoliosController::class, "update"]);
        Route::delete("/",[portfoliosController::class, "delete"]);
    });

    // Accounting Routes
    Route::get("/accounting",[homeController::class,"accounting"]);

    Route::prefix("/accounting")->group(function (){

        Route::prefix("/customers")->group(function(){
            Route::get("/",[CustomerController::class,"index"]);
            Route::get("/create",[CustomerController::class,"create"]);
            Route::post("/",[CustomerController::class,"store"]);
            Route::get("/{id}/edit",[CustomerController::class,"edit"]);
            Route::put("{id}",[CustomerController::class,"update"]);
            Route::get("{id}/inspect",[CustomerController::class,"inspect"]);
        });

        Route::prefix("/projects")->group(function(){
            Route::get("/",[ProjectController::class,"index"]);
            Route::get("/create",[ProjectController::class,"create"]);
            Route::post("/",[ProjectController::class,"store"]);
            Route::post("/cancel",[ProjectController::class,"cancel"]);
            Route::get("/{id}/edit",[ProjectController::class,"edit"]);
            Route::put("{id}",[ProjectController::class,"update"]);
            Route::delete("/{id}",[ProjectController::class,"delete"]);

            Route::get("/{id}/inspect",[ProjectController::class,"inspect"]);
        });

        Route::prefix("/customer-payments")->group(function(){
            Route::get("/",[CustomerPaymentController::class,"index"]);
            Route::get("/{id}/create",[CustomerPaymentController::class,"create"]);
            Route::post("/",[CustomerPaymentController::class,"store"]);
            Route::delete("/{id}",[CustomerPaymentController::class,"delete"]);
        });

        Route::prefix("/suppliers")->group(function(){
            Route::get("/",[SupplierController::class,"index"]);
            Route::get("/create",[SupplierController::class,"create"]);
            Route::post("/",[SupplierController::class,"store"]);
            Route::get("/{id}/edit",[SupplierController::class,"edit"]);
            Route::put("{id}",[SupplierController::class,"update"]);
            Route::get("{id}/inspect",[SupplierController::class,"inspect"]);
        });

        Route::prefix("/debts")->group(function(){
            Route::get("/",[DebtController::class,"index"]);
            Route::get("/create",[DebtController::class,"create"]);
            Route::post("/",[DebtController::class,"store"]);
            Route::get("/{id}/edit",[DebtController::class,"edit"]);
            Route::put("{id}",[DebtController::class,"update"]);
            Route::delete("/{id}",[DebtController::class,"delete"]);
            Route::get("/collective-pay",[DebtController::class,"collective_pay"]);
            Route::post("/collective-pay",[DebtController::class,"collective_pay_post"]);
        });

        Route::prefix("/debt-payments")->group(function(){
            Route::get("/",[DebtPaymentController::class,"index"]);
            Route::get("/{id}/create",[DebtPaymentController::class,"create"]);
            Route::post("/",[DebtPaymentController::class,"store"]);
            Route::delete("/{id}",[DebtPaymentController::class,"delete"]);
        });

        Route::prefix("/expenditures")->group(function(){
            Route::get("/",[ExpenditureController::class,"index"]);
            Route::get("/create",[ExpenditureController::class,"create"]);
            Route::post("/",[ExpenditureController::class,"store"]);
            Route::get("/{id}/edit",[ExpenditureController::class,"edit"]);
            Route::put("/{id}",[ExpenditureController::class,"update"]);
            Route::delete("/{id}",[ExpenditureController::class,"delete"]);
        });
    });

});


