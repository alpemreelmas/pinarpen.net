<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\DebtPayment;
use App\Models\Project;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class DebtController extends Controller
{
    public function index(){
        $debts = Debt::orderBy("updated_at","DESC")->get();
        $all_debt = Debt::sum("pending_payment");
        return view("management_panel.accounting.debts.index",compact("debts","all_debt"));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view("management_panel.accounting.debts.create",compact("suppliers"));
    }

    public function store(Request $request){
        $request->validate([
            "supplier_id"=>"required",
            "material_type"=>"required",
            "unit_price_of_material"=>"required|numeric|min:0.1",
            "square_meters"=>"required|min:0.1|numeric",
        ],[
            "supplier_id.required"=>"Bir hata meydana geldi lütfen daha sonra tekrar deneyiniz.",
            "material_type.required"=>"Lütfen materyal türünü seçiniz.",
            "unit_price_of_material.required"=>"Lütfen materyalin birim ücretini giriniz.",
            "unit_price_of_material.numeric"=>"Materyalin birim fiyatını sayı olarak giriniz.",
            "square_meters.numeric"=>"Metrekare alanını sayı olarak olacak şeklinde doldurunuz.",
            "square_meters.min"=>"Metrekare alanını en az :size olacak şekilde doldurunuz.",
            "unit_price_of_material.min"=>"Metrekare alanını en az :size olacak şekilde doldurunuz.",
            "square_meters.required"=>"Lütfen metrekare alanınını boş bırakmayınız.",
        ]);

        DB::transaction(function() use ($request) {
            $debts = new Debt();
            $debts->supplier_id = $request->supplier_id;
            $debts->material_type = $request->material_type;
            $debts->unit_price_of_material = (float)$request->unit_price_of_material;
            $debts->square_meters = (float)$request->square_meters;
            $debts->material_amount = (int)$request->material_amount;

            $cost = ((float)$request->unit_price_of_material)*((float)$request->square_meters)*(int)$request->material_amount;
            $debts->cost = $cost;
            $debts->pending_payment = $cost;
            $debts->paid_payment = 0;
            $debts->save();

        });

        return redirect("/admin/accounting/debts")->with("success","Tedarikçi borcu eklendi.");
    }

    public function edit($id){
        $suppliers = Supplier::all();
        $debt = Debt::whereId($id)->where("project_id",null)->firstOrFail();
        return view("management_panel.accounting.debts.edit",compact("suppliers","debt"));
    }

    public function update($id,Request $request){
        $request->validate([
            "supplier_id"=>"required",
            "material_type"=>"required",
            "unit_price_of_material"=>"required|numeric|min:0.1",
            "square_meters"=>"required|min:0.1|numeric",
        ],[
            "supplier_id.required"=>"Bir hata meydana geldi lütfen daha sonra tekrar deneyiniz.",
            "material_type.required"=>"Lütfen materyal türünü seçiniz.",
            "unit_price_of_material.required"=>"Lütfen materyalin birim ücretini giriniz.",
            "unit_price_of_material.numeric"=>"Materyalin birim fiyatını sayı olarak giriniz.",
            "square_meters.numeric"=>"Metrekare alanını sayı olarak olacak şeklinde doldurunuz.",
            "square_meters.min"=>"Metrekare alanını en az :size olacak şekilde doldurunuz.",
            "unit_price_of_material.min"=>"Metrekare alanını en az :size olacak şekilde doldurunuz.",
            "square_meters.required"=>"Lütfen metrekare alanınını boş bırakmayınız.",
        ]);

        $debt = Debt::whereId($id)->firstOrFail();

        if($debt->pending_payment == $debt->cost && $debt->paid_payment == 0){
            DB::transaction(function() use ($request,$debt) {
                $debt->supplier_id = $request->supplier_id;
                $debt->material_type = $request->material_type;
                $debt->unit_price_of_material = (float)$request->unit_price_of_material;
                $debt->square_meters = (float)$request->square_meters;
                $debt->material_amount = (int)$request->material_amount;

                $cost = ((float)$request->unit_price_of_material)*((float)$request->square_meters)*(int)$request->material_amount;
                $debt->cost = $cost;
                $debt->pending_payment = $cost;
                $debt->paid_payment = 0;
                $debt->save();

            });

            return redirect("/admin/accounting/debts")->with("success","Tedarikçi borcu yapılandırıldı..");
        }else{
            return redirect()->back()->withErrors("Bu tedarikçiye ödeme yapılmıştır. Bu yüzden bu borç düzenlenemez.");
        }

    }

    public function delete(Request $request)
    {
        $debt = Debt::whereId($request->id)->where("project_id",null)->firstOrFail();
        if($debt->paid_payment == 0 && $debt->pending_payment == $debt->cost && DebtPayment::where("debt_id",$request->id)->get()->count() == 0){
            DB::transaction(function () use ($debt){
                $debt->delete();
            });
            return redirect()->back()->with("success","Borç başarılı bir şekilde silinmiştir.");
        }else{
            return redirect()->back()->withErrors("Bu borca ödeme yapıldığı için maalesef silinemez.");
        }
    }

    public function collective_pay()
    {
        $suppliers = Supplier::whereRelation("getDebts","pending_payment",">","0")->get();
        if(Debt::sum("pending_payment") <= 0){
            return redirect()->back()->withErrors("Toplu ödeyebileceğiniz borç bulunmamaktadır.");
        }
        return view("management_panel.accounting.debts.collective_pay",compact("suppliers"));
    }

    public function collective_pay_post(Request $request)
    {
        $request->validate([
            "supplier_id"=>"required",
            "amount"=>"required|numeric"
        ],[
            "supplier_id.required"=>"Lütfen bir tedarikçi seçiniz.",
            "amount.required"=>"Lütfen miktar giriniz.",
            "amount.numeric"=>"Lütfen miktarı sayı olarak giriniz.",
        ]);

        if($request->amount <= 0){
            return redirect()->back()->withErrors("Lütfen 0'dan büyük bir sayı ile ödeme yapmayı deneyiniz.");
        }

        if(Debt::where("supplier_id",$request->supplier_id)->sum("pending_payment") < $request->amount){
            return redirect()->back()->withErrors("Toplu borcunuzdan fazla ödeme yapmaya çalışıyorsunuz.");
        }

        $remainder = $request->amount;

        $debts = Debt::where("supplier_id",$request->supplier_id)->where("pending_payment",">",0.00)->get();

        $id = explode("-",Uuid::uuid1())[0];

        for($i = 0; $i < $debts->count(); $i++){
            if($debts[$i]->pending_payment <= $remainder && $remainder !== 0 && $debts[$i]->pending_payment !== 0){
                    $remainder -= $debts[$i]->pending_payment;
                    $debts[$i]->paid_payment += $debts[$i]->pending_payment;

                    $debt_payment = new DebtPayment();
                    $debt_payment->payer_name = "TOPLU ÖDEME";
                    $debt_payment->payer_surname = $id;
                    $debt_payment->amount = $debts[$i]->pending_payment;
                    $debt_payment->debt_id = $debts[$i]->id;

                    $debts[$i]->pending_payment = 0;

                    $debts[$i]->save();
                    $debt_payment->save();
            }
        }

        $debts = Debt::where("supplier_id",$request->supplier_id)->where("pending_payment",">",0.00)->get();
        for($i = 0; $i < $debts->count(); $i++){
            if($debts[$i]->pending_payment > $remainder && $remainder !== 0){
                $debts[$i]->pending_payment -= $remainder;
                $debts[$i]->paid_payment += $remainder;

                $debt_payment = new DebtPayment();
                $debt_payment->payer_name = "TOPLU ÖDEME";
                $debt_payment->payer_surname = $id;
                $debt_payment->amount = $remainder;
                $debt_payment->debt_id = $debts[$i]->id;

                $remainder = 0;

                $debt_payment->save();
                $debts[$i]->save();
            }
        }

        return redirect("/admin/accounting/debts")->with("success","Toplu borç ödemesi 'TOPLU BORÇ $id' etiketi ile ödenmiştir.");
    }
}
