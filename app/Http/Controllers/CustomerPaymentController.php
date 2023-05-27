<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accounting\CustomerPayment\StoreRequest;
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

    public function create(Project $project)
    {
        $customers = Customer::select("name","surname")->get();
        // TODO let's check here to make just sql query instead of calculating this with for loop
        for($i = 0;$i < $customers->count(); $i++){
            $customers[$i]->value = $customers[$i]->name." ". $customers[$i]->surname;
        }
        if($project->is_cancelled){
            return redirect()->back()->withErrors("Bu proje iptal edildiği için ödeme yapılamaz.");
        }
        $project->cost == $project->paid_payment ?? redirect()->back()->withErrors("Bu projeye ödeme yapılamaz");

        return view("management_panel.accounting.customer_payments.create",compact("customers","project"));
    }

    public function store(StoreRequest $request,Project $project)
    {
        if($project->pending_payment < $request->amount){
            return redirect()->back()->withErrors("Borcu kapamak için ödenmesi gereken tutardan fazla tutar yatırıldı. İşleminiz iptal edilmiştir. Uygun tutar giriniz.");
        }

        DB::transaction(function() use ($request,$project) {

            $validated = array_merge($request->validated(),["project_id"=>$project->id]);
            CustomerPayment::create($validated);

            $project->pending_payment-=(int)$request->amount;
            $project->paid_payment+=(int)$request->amount;
            $project->save();
        });

        return redirect("/admin/accounting/projects/$project->id/customer-payments")->with("success","Borç başarılı bir şekilde yapılandırıldı.");

    }

    public function destroy(Request $request, Project $project, CustomerPayment $customerPayment)
    {
        DB::transaction(function() use ($request,$project,$customerPayment) {
            $project->pending_payment+=(int)$customerPayment->amount;
            $project->paid_payment-=(int)$customerPayment->amount;
            $project->save();
            $customerPayment->delete();
        });

        return redirect("/admin/accounting/projects/$project->id/customer-payments")->with("success","Borç başarılı bir şekilde yapılandırıldı.");
    }
}
