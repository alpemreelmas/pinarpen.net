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

        Route::resource("customers",CustomerController::class)->except("destroy");
        Route::get("/customers/{id}/inspect",[CustomerController::class,"inspect"])->name("customers.inspect");

        Route::resource("projects",ProjectController::class);
        Route::prefix("/projects")->name("projects.")->group(function (){
            Route::post("/cancel",[ProjectController::class,"cancel"])->name("cancel");
            Route::get("/{id}/inspect",[ProjectController::class,"inspect"])->name("inspect");
        });

        Route::resource("customer-payments",CustomerPaymentController::class)->except(["edit","update"]);

        Route::resource("suppliers",SupplierController::class)->except("destroy");
        Route::get("/suppliers/{id}/inspect",[SupplierController::class,"inspect"])->name("suppliers.inspect");

        Route::resource("debts",DebtController::class);
        Route::prefix("/debts")->name("debts.")->group(function(){
            Route::get("/collective-pay",[DebtController::class,"collective_pay"])->name("collective_pay");
            Route::post("/collective-pay",[DebtController::class,"collective_pay_post"])->name("collective_pay_post");
        });

        Route::resource("debt-payments",DebtPaymentController::class)->except(["edit","update"]);
        Route::resource("expenditures",ExpenditureController::class);
    });
});


