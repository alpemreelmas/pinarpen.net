<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "surname"=>"required",
            "phone_number"=>"required",
        ],[
            "name.required"=>"Lütfen müşteri isim alanını boş bıramayınız.",
            "surname.required"=>"Lütfen müşteri soyisim alanını boş bıramayınız.",
            "phone_number.required"=>"Lütfen müşteri iletişim numarası alanını boş bıramayınız.",
            "phone_number.min"=>"Müşteri iletişim numarası alanı en az :min karakter olmalıdır.",
            "phone_number.max"=>"Müşteri iletişim numarası alanı en fazla :max karakter olabilir.",
        ]);

        if(Customer::where("name",$request->name)->where("surname",$request->surname)->first()){
            return redirect()->back()->withErrors($request->name." ".$request->surname." adına ve soyadına ait kayıtlı müşteri vardır.");
        }

        DB::transaction(function() use ($request) {
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->surname = $request->surname;
            $customer->phone_number = $request->phone_number;
            $customer->address = $request->address ? $request->address : null;
            $customer->save();
        });

        return redirect("/admin/accounting/customers")->with("success","Müşteri başarılı bir şekilde eklenmiştir.");
    }

    public function edit($id)
    {
        $customer = Customer::whereId($id)->firstOrFail();
        return view("management_panel.accounting.customers.edit",compact("customer"));
    }

    public function update($id,Request $request)
    {
        $request->validate([
            "name"=>"required",
            "surname"=>"required",
            "phone_number"=>"required",
        ],[
            "name.required"=>"Lütfen müşteri isim alanını boş bıramayınız.",
            "surname.required"=>"Lütfen müşteri soyisim alanını boş bıramayınız.",
            "phone_number.required"=>"Lütfen müşteri iletişim numarası alanını boş bıramayınız.",
            "phone_number.min"=>"Müşteri iletişim numarası alanı en az :min karakter olmalıdır.",
            "phone_number.max"=>"Müşteri iletişim numarası alanı en fazla :max karakter olabilir.",
        ]);

        if(Customer::where("name",$request->name)->where("surname",$request->surname)->whereNotIn("id",[$id])->first()){
            return redirect()->back()->withErrors($request->name." ".$request->surname." adına ve soyadına ait kayıtlı müşteri vardır.");
        }

        DB::transaction(function() use ($request,$id) {

            $customer = Customer::whereId($id)->firstOrFail();
            $customer->name = $request->name;
            $customer->surname = $request->surname;
            $customer->phone_number = $request->phone_number;
            $customer->address = $request->address ? $request->address : null;
            $customer->save();
        });

        return redirect("/admin/accounting/customers")->with("success","Müşteri başarılı bir şekilde düzenlenmiştir.");
    }

    public function inspect($id){
        $customer = Customer::whereId($id)->firstOrFail();
        $all_debt = Project::where("customer_id",$customer->id)->sum("cost");
        $paid_payment = Project::where("customer_id",$customer->id)->sum("paid_payment");
        return view("management_panel.accounting.customers.inspect",compact("customer","all_debt","paid_payment"));
    }

}
