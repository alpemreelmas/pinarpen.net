<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accounting\Project\StoreRequest;
use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\Debt;
use App\Models\Project;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view("management_panel.accounting.projects.index",compact("projects"));
    }

    public function create(){
        $customers = Customer::select("id","name","surname")->get();
        for($i = 0;$i < $customers->count(); $i++){
            $customers[$i]->value = $customers[$i]->name." ". $customers[$i]->surname;
        }
        $suppliers = Supplier::all();
        for($i = 0;$i < $suppliers->count(); $i++){
            $suppliers[$i]->value = $suppliers[$i]->name;
        }
        return view("management_panel.accounting.projects.create",compact("customers","suppliers"));

    }

    public function store(StoreRequest $request){

        $customer = Customer::whereId($request->customer_id)->first();
        if($customer){
            if($customer->name." ".$customer->surname !== $request->customer_name){
                return redirect()->back()->withErrors("Böyle bir müşteri bulunamadı. Lütfen daha sonra tekrar deneyiniz.");
            }
        }else{
            return redirect()->back()->withErrors("Böyle bir müşteri bulunamadı. Lütfen daha sonra tekrar deneyiniz.");
        }

        $supplier = Supplier::whereId($request->supplier_id)->first();

        if($supplier){
            if($supplier->name !== $request->supplier_name){
                return redirect()->back()->withErrors("Böyle bir tedarikçi bulunamadı. Lütfen daha sonra tekrar deneyiniz.");
            }
        }else{
            return redirect()->back()->withErrors("Böyle bir tedarikçi bulunamadı. Lütfen daha sonra tekrar deneyiniz.");
        }



        DB::transaction(function() use ($request) {
            $project = new Project();
            $project->customer_id = $request->customer_id;
            $project->supplier_id = $request->supplier_id;
            $project->material_type = $request->material_type;
            $project->material_amount = (int)$request->material_amount;
            $project->payment_type = $request->payment_type;
            $project->unit_price_of_material = (float)$request->unit_price_of_material;
            $project->square_meters = (float)$request->square_meters;
            $project->earning = (int)$request->earning;

            $project->note = $request->note ? $request->note : null;

            $expenditure = ((float)((float)$request->unit_price_of_material*(float)$request->square_meters)*(int)$request->material_amount);

            $project->cost = $expenditure+(int)$request->earning;
            $project->pending_payment =  $project->cost;
            $project->paid_payment = 0;
            $project->pay_date = $request->pay_date;
            $project->save();

            if($request->is_stock == "false"){
                $debt = new Debt();
                $debt->supplier_id = $request->supplier_id;
                $debt->project_id = $project->id;
                $debt->material_type = $request->material_type;
                $debt->unit_price_of_material = (float)$request->unit_price_of_material;
                $debt->square_meters = (float)$request->square_meters;
                $debt->material_amount = (int)$request->material_amount;
                $debt->pending_payment = $expenditure;
                $debt->paid_payment = 0;
                $debt->cost = $expenditure;
                $debt->save();
            }
        });


        return redirect("/admin/accounting/projects")->with("success","Proje başarılı bir şekilde kayıt edilmiştir.");

    }

    public function edit($id)
    {
        $customers = Customer::select("id","name","surname")->get();
        for($i = 0;$i < $customers->count(); $i++){
            $customers[$i]->value = $customers[$i]->name." ". $customers[$i]->surname;
        }

        $suppliers = Supplier::select("id","name")->get();
        for($i = 0;$i < $suppliers->count(); $i++){
            $suppliers[$i]->value = $suppliers[$i]->name;
        }

        $project = Project::whereId($id)->firstOrFail();

        if($project->paid_payment > 0){
            return redirect("admin/accounting/projects")->withErrors("Bu proje ödeme yaptığı için güncelleme işlemi yapılamaz.");
        }

        $project->expenditure = ((float)($project->unit_price_of_material*$project->square_meters)*$project->material_amount);

        return view("management_panel.accounting.projects.edit",compact("project","customers","suppliers"));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            "customer_id"=>"required",
            "customer_name"=>"required",
            "material_type"=>"required",
            "material_amount"=>"required",
            "payment_type"=>"required",
            "supplier_id"=>"required",
            "unit_price_of_material"=>"required|numeric|min:0.1",
            "square_meters"=>"required|min:0.1|numeric",
        ],[
            "supplier_id.required"=>"Bir hata meydana geldi lütfen daha sonra tekrar deneyiniz.",
            "customer_id.required"=>"Lütfen bir müşteri seçiniz.",
            "unit_price_of_material.required"=>"Lütfen materyalin birim ücretini giriniz.",
            "unit_price_of_material.numeric"=>"Materyalin birim fiyatını sayı olarak giriniz.",
            "square_meters.numeric"=>"Metrekare alanını sayı olarak olacak şeklinde doldurunuz.",
            "square_meters.min"=>"Metrekare alanını en az :size olacak şekilde doldurunuz.",
            "unit_price_of_material.min"=>"Metrekare alanını en az :size olacak şekilde doldurunuz.",
            "square_meters.required"=>"Lütfen metrekare alanınını boş bırakmayınız.",
            "material_type.required"=>"Lütfen bir materyal türünü boş bıramayınız.",
            "material_amount.required"=>"Lütfen bir materyal adetini boş bıramayınız.",
            "payment_type.required"=>"Lütfen bir ödeme türü seçiniz.",
            "costumer_name.required"=>"Lütfen bir müşteri seçiniz.",
        ]);

        $project = Project::whereId($id)->firstOrFail();

        if($project->pending_payment != $project->cost || $project->paid_payment != 0){
            return redirect()->back()->withErrors("Bu alıcı ödeme yapmış olduğu için düzenlenemez veya silinemez.");
        }


        $customer = Customer::whereId($request->customer_id)->first();
        if($customer){
            if($customer->name." ".$customer->surname !== $request->customer_name){
                return redirect()->back()->withErrors("Böyle bir müşteri bulunamadı. Lütfen daha sonra tekrar deneyiniz.");
            }
        }else{
            return redirect()->back()->withErrors("Böyle bir müşteri bulunamadı. Lütfen daha sonra tekrar deneyiniz.");
        }

        DB::transaction(function() use ($request,$id,$project) {

            $project->customer_id = $request->customer_id;
            $project->supplier_id = $request->supplier_id;
            $project->material_type = $request->material_type;
            $project->material_amount = (int)$request->material_amount;
            $project->payment_type = $request->payment_type;
            $project->unit_price_of_material = (float)$request->unit_price_of_material;
            $project->square_meters = (float)$request->square_meters;
            $project->earning = (int)$request->earning;

            $project->note = $request->note ? $request->note : null;

            $expenditure = ((float)((float)$request->unit_price_of_material*(float)$request->square_meters)*(int)$request->material_amount);

            $project->cost = $expenditure+(int)$request->earning;
            $project->pending_payment =  $project->cost;
            $project->paid_payment = 0;
            $project->pay_date = $request->pay_date;
            $project->save();

            $debt = Debt::where("project_id",$project->id)->first();
            if($debt){
                $debt->supplier_id = $request->supplier_id;
                $debt->project_id = $project->id;
                $debt->material_type = $request->material_type;
                $debt->unit_price_of_material = (float)$request->unit_price_of_material;
                $debt->square_meters = (float)$request->square_meters;
                $debt->material_amount = (int)$request->material_amount;
                $debt->pending_payment = $expenditure;
                $debt->paid_payment = 0;
                $debt->cost = $expenditure;
                $debt->save();
            }

        });


        return redirect("/admin/accounting/projects")->with("success","Proje başarılı bir şekilde güncellenmiştir.");

    }

    public function destroy(Request $request)
    {
        $project = Project::whereId($request->id)->firstOrFail();
        if($project->paid_payment == 0 && $project->pending_payment == $project->cost && CustomerPayment::where("project_id",$request->id)->get()->count() == 0){
            $debt = Debt::where("project_id",$project->id)->first();
            if($debt->paid_payment !== 0){
                return redirect()->back()->withErrors("Tedarikçiye borç ödesi yapıldığı için bu proje silinemez.");
            }
            DB::transaction(function () use ($project,$debt){
                $debt->delete();
                $project->delete();
            });

            return redirect()->back()->with("success","Proje başarılı bir şekilde silinmiştir.");
        }else{
            return redirect()->back()->withErrors("Bu proje, ödeme yapıldığı için silinemez.");
        }
    }

    public function inspect($id)
    {
        $project = Project::whereId($id)->firstOrFail();
        return view("management_panel.accounting.projects.inspect",compact("project"));
    }

    public function cancel(Request $request)
    {
        $request->validate(["id"=>"required"]);

        $project = Project::where("id",$request->id)->firstOrFail();

        if($project->is_cancelled){
          return redirect()->back()->withErrors("Bu proje zaten iptal edilmiştir.");
        }

        if($project->paid_payment > 0){
          return redirect()->back()->withErrors("Bu proje ödeme alındığı için iptal edilemez.");
        }

        $project->is_cancelled = true;
        $project->save();


        return redirect()->back()->with("success","Proje başarılı bir şekilde iptal edilmiştir.");
    }
}
