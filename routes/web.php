<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\PortfoliosController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CustomerPaymentController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\DebtPaymentController;
use App\Http\Controllers\ExpenditureController;

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

Route::get("/",[HomeController::class,"index"]);

Route::get("/about",[HomeController::class,"about"]);

Route::get("/contact",[HomeController::class,"contact"]);

Route::get("/portfolios",[HomeController::class,"portfolios"]);
Route::get("/portfolios/{slug}/{id}",[HomeController::class,"portfolios_detail"]);

Route::get("/services",[HomeController::class,"services"]);

Route::get("/admin", [AdminController::class,"checkPath"]);

Route::get("/admin/login",[AdminController::class,"login"]);
Route::post("/admin/login",[AdminController::class,"login_post"]);

Route::prefix('admin')->middleware(["is_admin"])->group(function () {

    Route::get('/dashboard', [AdminController::class,"dashboard"]);

    Route::post("/logout",[AdminController::class,"logout"]);

    Route::prefix('services')->group(function () {
        Route::get('/', [ServicesController::class, 'index']);
        Route::get('/create', [ServicesController::class, 'create']);
        Route::post("/",[ServicesController::class, "store"]);
        Route::get("/{id}/edit",[ServicesController::class, "edit"]);
        Route::put("/{id}",[ServicesController::class, "update"]);
        Route::delete("/",[ServicesController::class, "delete"]);
    });

    Route::resource('portfolios',PortfoliosController::class);

    // Accounting Routes
    Route::get("/accounting",[HomeController::class,"accounting"]);

    Route::prefix("/accounting")->group(function (){

        Route::resource("customers",CustomerController::class)->except("destroy","show");
        Route::get("/customers/{customer}/inspect",[CustomerController::class,"inspect"])->name("customers.inspect");

        Route::resource("projects",ProjectController::class);
        Route::prefix("/projects")->name("projects.")->group(function (){
            Route::post("/cancel",[ProjectController::class,"cancel"])->name("cancel");
            Route::get("/{id}/inspect",[ProjectController::class,"inspect"])->name("inspect");
            Route::prefix("/{project}")->group(function (){
                Route::resource("customer-payments",CustomerPaymentController::class)->except(["show","edit","update"]);
            });
        });

        Route::resource("suppliers",SupplierController::class)->except("destroy");
        Route::get("/suppliers/{id}/inspect",[SupplierController::class,"inspect"])->name("suppliers.inspect");

        Route::resource("debts",DebtController::class);
        Route::prefix("/debts")->name("debts.")->group(function(){
            Route::get("/collective-pay",[DebtController::class,"collective_pay"])->name("collective_pay");
            Route::post("/collective-pay",[DebtController::class,"collective_pay_post"])->name("collective_pay_post");
        });

        Route::resource("debt-payments",DebtPaymentController::class)->except(["edit","update"]);
        Route::resource("expenditures",ExpenditureController::class);
        Route::get("/expenditures/{id}", [ExpenditureController::class, "update"]);
    });
});


