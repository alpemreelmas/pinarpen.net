<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $request->validate([
           "name"=>"required",
           "material_type"=>"required",
           "iban"=>"required|numeric"
        ],[
            "name.required"=>"Lütfen tedarikçi ismi giriniz.",
            "material_type.required"=>"Lütfen tedarikçinin sattığı materyal türünü seçiniz.",
            "iban.required"=>"Lütfen tedarikçinin iban adresini giriniz.",
            "iban.integer"=>"Lütfen tedarikçinin iban adresini sadece sayı şeklinde giriniz."
        ]);

        if(Supplier::where("name",$request->name)->first()){
            return redirect()->back()->withErrors($request->name." adına sahip bir tedarikçi var.");
        }

        if(strlen($request->iban) != 24){
            return redirect()->back()->withErrors("Lütfen ibanın TR kısmı hariç 24 hane olacak şekilde girildiğinden emin olunuz.");
        }

        DB::transaction(function() use ($request) {

            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->material_type = $request->material_type;
            $supplier->iban = $request->iban;
            $supplier->save();
        });

        return redirect("/admin/accounting/suppliers/")->with("success","Tedarikçi başarılı bir şekilde kayıt edilmiştir.");

    }

    public function edit($id)
    {
        $supplier = Supplier::whereId($id)->firstOrFail();
        return view("management_panel.accounting.suppliers.edit",compact("supplier"));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "name"=>"required",
            "material_type"=>"required",
            "iban"=>"required|numeric",
        ],[
            "name.required"=>"Lütfen tedarikçi ismi giriniz.",
            "material_type.required"=>"Lütfen tedarikçinin sattığı materyal türünü seçiniz.",
            "iban.required"=>"Lütfen tedarikçinin iban adresini giriniz.",
            "iban.integer"=>"Lütfen tedarikçinin iban adresini sadece sayı şeklinde giriniz."
        ]);

        if(Supplier::where("name",$request->name)->whereNotIn("id",[$id])->first()){
            return redirect()->back()->withErrors($request->name." adına sahip bir tedarikçi var.");
        }

        DB::transaction(function() use ($request,$id) {

            $supplier = Supplier::whereId($id)->firstOrFail();
            $supplier->name = $request->name;
            $supplier->material_type = $request->material_type;
            $supplier->iban = $request->iban;
            $supplier->save();
        });

        return redirect("/admin/accounting/suppliers/")->with("success","Tedarikçi başarılı bir şekilde güncellenmiştir.");

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
