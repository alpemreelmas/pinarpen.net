<?php

namespace App\Http\Controllers;

use App\Models\DebtPayment;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DebtPaymentController extends Controller
{
    public function index()
    {
        $debt_payments = DebtPayment::orderBy("created_at","DESC")->get();

        $debts = new Collection();

        foreach ($debt_payments as $debt){
            if(Str::isUuid($debt->payer_surname)){
                if($debts->whereIn("payer_surname",[$debt->payer_surname])->count() <= 0){
                    $collective_debt_payment = DebtPayment::where("payer_surname",$debt->payer_surname)->sum("amount");
                    $debt->amount = $collective_debt_payment;
                    $debts->push($debt);
                    $debt_payments = $debt_payments->whereNotIn('payer_surname', [$debt->payer_surname]);
                }
            }else{
                $debts->push($debt);
            }
        }
        $debt_payments = $debts;

        return view("management_panel.accounting.debt_payments.index",compact("debt_payments"));
    }

    public function create($id)
    {
        $debt = Debt::whereId($id)->where("pending_payment",">",0)->firstOrFail();
        return view("management_panel.accounting.debt_payments.create",compact("debt"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "payer_name"=>"required",
            "payer_surname"=>"required",
            "amount"=>"required",
            "debt_id"=>"required",
        ],[
            "payer_name.required"=>"Lütfen kimin ödediğini yazınız.",
            "payer_surname.required"=>"Lütfen kimin ödediğini yazınız.",
            "debt_id.required"=>"Bir hata meydana geldi lütfen tekrar deneyiniz.",
            "amount.required"=>"Lütfen bir borç tutarı giriniz."
        ]);

        if($request->amount <= 0){
            return redirect()->back()->withErrors("Lütfen ödeme miktarını kontrol ediniz.");
        }

        $debt = Debt::where("id",$request->debt_id)->where("pending_payment",">",0)->firstOrFail();

        if($debt->pending_payment < $request->amount){
            return redirect()->back()->withErrors("Kalan borç tutarından fazla borç ödemesi yapmaya çalışıyorsunuz. Yapılabilecek en fazla tutar ".$debt->pending_payment."TL'dir.");
        }

        DB::transaction(function () use ($request,$debt){

            $debt->pending_payment -= (float)$request->amount;
            $debt->paid_payment += (float)$request->amount;

            $debt_payment = new DebtPayment();
            $debt_payment->payer_name = $request->payer_name;
            $debt_payment->payer_surname = $request->payer_surname;
            $debt_payment->amount = $request->amount;
            $debt_payment->debt_id = $debt->id;
            $debt_payment->save();
            $debt->save();
        });

        return redirect("/admin/accounting/debt-payments")->with("success","Başarılı bir şekilde ödeme yapılmıştır.");

    }

    public function destroy(Request $request)
    {
        $debt_payment = DebtPayment::whereId($request->id)->firstOrFail();
        //TODO kısa yolu var mı kontrol et.
        $debt = Debt::whereId($debt_payment->debt_id)->firstOrFail();
        DB::transaction(function() use ($request,$debt,$debt_payment) {

            $debt->pending_payment+=(float)$debt_payment->amount;
            $debt->paid_payment-=(float)$debt_payment->amount;
            $debt->save();


            $debt_payment->delete();

        });

        return redirect("/admin/accounting/debt-payments")->with("success","Borç başarılı bir şekilde yapılandırıldı.");
    }
}
