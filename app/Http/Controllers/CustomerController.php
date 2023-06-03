<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accounting\Customer\StoreRequest;
use App\Http\Requests\Accounting\Customer\UpdateRequest;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view("management_panel.accounting.customers.index",compact("customers"));
    }

    public function create()
    {
        return view("management_panel.accounting.customers.create");
    }

    public function store(StoreRequest $request)
    {
        if(Customer::where("name",$request->name)->where("surname",$request->surname)->first()){
            return redirect()->back()->withErrors(trans("customer.already_exist",["name"=>$request->name." ".$request->surname]));
        }

        DB::transaction(function() use ($request) {
            Customer::create($request->validated());
        });

        return redirect("/admin/accounting/customers")->with("success",trans("general.successful"));
    }

    public function edit(Customer $customer)
    {
        return view("management_panel.accounting.customers.edit",compact("customer"));
    }

    public function update(Customer $customer,UpdateRequest $request)
    {
        if(Customer::where("name",$request->name)->where("surname",$request->surname)->whereNotIn("id",[$customer->id])->first()){
            return redirect()->back()->withErrors(trans("customer.already_exist",["name"=>$request->name." ".$request->surname]));
        }

        DB::transaction(function() use ($request,$customer) {
            $customer->update($request->validated());
        });

        return redirect("/admin/accounting/customers")->with("success",trans("general.successful"));
    }

    public function inspect(Customer $customer){
        $all_debt = $customer->getAllDebts();
        $paid_payment = $customer->getPaidDebts();
        return view("management_panel.accounting.customers.inspect",compact("customer","all_debt","paid_payment"));
    }
}
