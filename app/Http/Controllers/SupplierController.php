<?php

namespace App\Http\Controllers;


use App\Http\Requests\Accounting\Suppliers\StoreRequest;
use App\Http\Requests\Accounting\Suppliers\UpdateRequest;
use App\Models\Debt;
use App\Models\DebtPayment;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view("management_panel.accounting.suppliers.index",compact("suppliers"));
    }

    public function create()
    {
        return view("management_panel.accounting.suppliers.create");
    }

    public function store(StoreRequest $request)
    {

        if(Supplier::where("name",$request->name)->first()){
            return redirect()->back()->withErrors(trans("supplier.already_exist",["name"=>$request->name]));
        }

        if(strlen($request->iban) != 24){
            return redirect()->back()->withErrors(trans("suppliers.iban_error"));
        }

        DB::transaction(function() use ($request) {
            Supplier::create($request->validated());
        });

        return redirect("/admin/accounting/suppliers/")->with("success",trans("general.successful"));

    }

    public function edit($id)
    {
        $supplier = Supplier::whereId($id)->firstOrFail();
        return view("management_panel.accounting.suppliers.edit",compact("supplier"));
    }

    public function update($id, Request $request)
    {

        if(Supplier::where("name",$request->name)->whereNotIn("id",[$id])->first()){
            return redirect()->back()->withErrors(trans("supplier.already_exist",["name"=>$request->name]));
        }

        DB::transaction(function() use ($request,$id) {
            Supplier::update($request->validated());
        });

        return redirect("/admin/accounting/suppliers/")->with("success",trans("general.successful"));

    }

    public function inspect($id)
    {
        $supplier = Supplier::where("id",$id)->firstOrFail();
        $all_debt = Debt::where("supplier_id",$supplier->id)->sum("cost");
        $paid_payment = Debt::where("supplier_id",$supplier->id)->sum("paid_payment");

        $debts = new Collection();

        $getDebts = $supplier->getPayments;

        foreach ($getDebts as $debt ){
            if(Str::isUuid($debt->payer_surname)){
                if($debts->whereIn("payer_surname",[$debt->payer_surname])->count() <= 0) {
                    $collective_debt_payment = DebtPayment::where("payer_surname", $debt->payer_surname)->sum("amount");
                    $debt->amount = $collective_debt_payment;
                    $debts->push($debt);
                    $getDebts = $getDebts->whereNotIn('payer_surname', [$debt->payer_surname]);
                }
            }else{
                $debts->push($debt);
            }
        }

        return view("management_panel.accounting.suppliers.inspect",compact("supplier","all_debt","paid_payment","debts"));
    }
}
