<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\Portfolio;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPaymentController extends Controller
{
    public function index()
    {
        $customer_payments = CustomerPayment::orderBy("updated_at","DESC")->get();
        return view("management_panel.accounting.customer_payments.index",compact("customer_payments"));
    }

    public function create($id)
    {
        $customers = Customer::select("name","surname")->get();
        for($i = 0;$i < $customers->count(); $i++){
            $customers[$i]->value = $customers[$i]->name." ". $customers[$i]->surname;
        }
        $project = Project::whereId($id)->whereColumn("paid_payment", "!=" ,"cost")->firstOrFail();

        if($project->is_cancelled){
            return redirect()->back()->withErrors("Bu proje iptal edildiği için ödeme yapılamaz.");
        }

        return view("management_panel.accounting.customer_payments.create",compact("customers","project"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "project_id"=>"required",
            "amount"=>"required",
            "payer_name"=>"required",
        ],[
          "project_id.required"=>"Bir hata meydana geldi lütfen daha sonra tekrar deneyiniz.",
          "amount.required"=>"Lütfen geçerli bir fatura tutarı giriniz.",
          "payer_name"=>"Lütfen ödeyen adını ekleyiniz."
        ]);

        $project = Project::whereId($request->project_id)->whereColumn("paid_payment", "!=" ,"cost")->firstOrFail();

        if($request->amount <= 0){
            return redirect()->back()->withErrors("Lütfen ödeme miktarını kontrol ediniz.");
        }

        if($project->pending_payment < $request->amount){
            return redirect()->back()->withErrors("Borcu kapamak için ödenmesi gereken tutardan fazla tutar yatırıldı. İşleminiz iptal edilmiştir. Uygun tutar giriniz.");
        }

        DB::transaction(function() use ($request,$project) {

            $customer_payment = new CustomerPayment();
            $customer_payment->project_id = $project->id;
            $customer_payment->amount = (int)$request->amount;
            $customer_payment->payer = $request->payer_name;
            $customer_payment->save();

            $project->pending_payment-=(int)$request->amount;
            $project->paid_payment+=(int)$request->amount;
            $project->save();
        });

        return redirect("/admin/accounting/customer-payments")->with("success","Borç başarılı bir şekilde yapılandırıldı.");

    }

    public function destroy(Request $request)
    {
        $customer_payment = CustomerPayment::whereId($request->id)->firstOrFail();
        //TODO kısa yolu var mı kontrol et.
        $project = Project::whereId($customer_payment->project_id)->firstOrFail();
        DB::transaction(function() use ($request,$project,$customer_payment) {

            $project->pending_payment+=(int)$customer_payment->amount;
            $project->paid_payment-=(int)$customer_payment->amount;
            $project->save();


            $customer_payment->delete();

        });

        return redirect("/admin/accounting/customer-payments")->with("success","Borç başarılı bir şekilde yapılandırıldı.");
    }
}
